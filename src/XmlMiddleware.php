<?php
namespace GuzzleXml;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class XmlMiddleware
{
    const HEADER_CONTENT_TYPE = 'Content-Type';
    const MIME_TYPE_XML = 'text/xml';
    const OPTION_XML = 'xml';

    public static function xml()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if (!isset($options[self::OPTION_XML])) {
                    return $handler($request, $options);
                }

                $root = key($options[self::OPTION_XML]);
                if ($root) {
                    $encoder = new XmlEncoder([
                        XmlEncoder::ROOT_NODE_NAME => $root
                    ]);
                    $data = current($options[self::OPTION_XML]);
                } else {
                    $encoder = new XmlEncoder();
                    $data = $options[self::OPTION_XML];
                }

                $body = $encoder->encode($data, XmlEncoder::FORMAT);
                unset($options[self::OPTION_XML]);
                $request = $request->withHeader(self::HEADER_CONTENT_TYPE, self::MIME_TYPE_XML)
                    ->withBody(\GuzzleHttp\Psr7\stream_for($body));

                return $handler($request, $options);
            };
        };
    }

    public static function jsonToXml()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                $promise = $handler($request, $options);
                return $promise->then(
                    function (ResponseInterface $response) {
                        $json = (string) $response->getBody();
                        if (!$json) {
                            return $response;
                        }

                        $encoder = new JsonEncoder();
                        $schema = $encoder->decode($json, JsonEncoder::FORMAT);

                        $root = key($schema);
                        if (!$root) {
                            throw new NotEncodableValueException();
                        }

                        $encoder = new XmlEncoder([
                            XmlEncoder::ROOT_NODE_NAME => $root
                        ]);
                        $data = current($schema);
                        $body = $encoder->encode($data, XmlEncoder::FORMAT);
                        return $response->withHeader(self::HEADER_CONTENT_TYPE, self::MIME_TYPE_XML)
                            ->withBody(\GuzzleHttp\Psr7\stream_for($body));
                    }
                );
            };
        };
    }
}
