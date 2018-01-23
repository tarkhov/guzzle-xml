<?php
namespace GuzzleXml;

use Psr\Http\Message\RequestInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class Middleware
{
    const HEADER_CONTENT_TYPE = 'Content-Type';
    const MIME_TYPE_XML = 'text/xml';
    const OPTION_XML = 'xml';

    public static function xml()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if (empty($options[self::OPTION_XML])) {
                    return $handler($request, $options);
                }

                $root = key($options[self::OPTION_XML]);
                $data = current($options[self::OPTION_XML]);
                if (!$root || !$data) {
                    return $handler($request, $options);
                }

                $encoder = new XmlEncoder($root);
                $body = $encoder->encode($data, XmlEncoder::FORMAT);
                unset($options[self::OPTION_XML]);
                $request = $request->withHeader(self::HEADER_CONTENT_TYPE, self::MIME_TYPE_XML)
                    ->withBody(\GuzzleHttp\Psr7\stream_for($body));

                return $handler($request, $options);
            };
        };
    }
}
