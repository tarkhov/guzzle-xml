<?php
namespace GuzzleXml;

use Psr\Http\Message\RequestInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class Middleware
{
    const HEADER = 'Content-Type';
    const MIME   = 'text/xml';
    const OPTION = 'xml';

    public static function xml()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                if (!empty($options[self::OPTION])) {
                    $root = key($options[self::OPTION]);
                    $data = current($options[self::OPTION]);
                    if ($root && $data) {
                        $encoder = new XmlEncoder($root);
                        $body = $encoder->encode($data, XmlEncoder::FORMAT);
                        unset($options[self::OPTION]);
                        $request = $request->withHeader(self::HEADER, self::MIME)
                            ->withBody(\GuzzleHttp\Psr7\stream_for($body));
                    }
                }

                return $handler($request, $options);
            };
        };
    }
}
