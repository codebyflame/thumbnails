<?php

namespace CodeByFlame\Thumbnails;

class Generator
{
    /**
     * @param string $title
     * @param array $opts
     */
    public static function generate(string $title, array $opts = [])
    {
        try {
            self::make($title, [
                'image_size' => isset($opts['targetSize']) ? $opts['targetSize'] : '1200x630',
                'font_size' => isset($opts['fontSize']) ? $opts['fontSize'] : 55,
                'text_color' => $opts['text_color'] ? $opts['text_color'] : '#111',
                'background_color' => $opts['background_color'] ? $opts['background_color'] : '#fff',
                'path_to_font' => __DIR__ . '/../resources/fonts/inter-800.ttf',
            ]);
        } catch(\Exception $e) {
            return $e;
        }
    }

    /**
     * @param string $title
     * @return string
     */
    private static function normalizeTitle(string $title): string
    {
        $title = mb_convert_encoding($title, 'HTML-ENTITIES', "UTF-8");

        // Convert HTML entities into ISO-8859-1
        $title = html_entity_decode($title,ENT_NOQUOTES, "ISO-8859-1");

        // Convert characters > 127 into their hexidecimal equivalents
        $out = "";
        for($i = 0; $i < strlen($title); $i++) {
            $letter = $title[$i];
            $num = ord($letter);
            if($num>127) {
                $out .= "&#$num;";
            } else {
                $out .=  $letter;
            }
        }

        return $out;
    }

    /**
     * @param string $title
     * @param int $width
     * @param string $break
     * @return string
     */
    private static function wrapTitle(string $title, int $width = 75, $break = "\n"): string
    {
        $pattern = sprintf('/([^ ]{%d,})/', $width);
        $output = '';
        $words = preg_split($pattern, $title, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        foreach ($words as $word) {
            if (false !== strpos($word, ' ')) {
                // normal behaviour, rebuild the string
                $output .= $word;
            } else {
                // work out how many characters would be on the current line
                $wrapped = explode($break, wordwrap($output, $width, $break));
                $count = $width - (strlen(end($wrapped)) % $width);

                // fill the current line and add a break
                $output .= substr($word, 0, $count) . $break;

                // wrap any remaining characters from the problem word
                $output .= wordwrap(substr($word, $count), $width, $break, true);
            }
        }

        return wordwrap($output, $width, $break);
    }

    /**
     * @param string $title
     * @return string
     */
    private static function parseTitle(string $title): string
    {
        $normalizedTitle = self::normalizeTitle($title);
        $wrappedTitle = self::wrapTitle($normalizedTitle, 23);
        $maxCharacters = 125;

        if(strlen($wrappedTitle) > $maxCharacters) {
            return substr($wrappedTitle, 0, $maxCharacters) . ' ...';
        }

        return $wrappedTitle;
    }

    /**
     * @param $resource
     * @param $hex
     * @return false|int
     */
    private static function allocateColor($resource, $hex)
    {
        $rgb = self::hexToRgb($hex);

        return imagecolorallocate($resource, $rgb['r'], $rgb['g'], $rgb['b']);
    }

    /**
     * @param $hex
     * @return array|false
     */
    private static function hexToRgb($hex)
    {
        $hex = preg_replace("/[^abcdef0-9]/i", "", $hex);

        if (strlen($hex) == 6) {
            list($r, $g, $b) = str_split($hex, 2);

            return [
                "r" => hexdec($r),
                "g" => hexdec($g),
                "b" => hexdec($b)
            ];
        } elseif (strlen($hex) == 3) {
            list($r, $g, $b) = array($hex[0] . $hex[0], $hex[1] . $hex[1], $hex[2] . $hex[2]);

            return [
                "r" => hexdec($r),
                "g" => hexdec($g),
                "b" => hexdec($b)
            ];
        }

        return false;
    }

    /**
     * @param string $title
     * @param array $opts
     * @throws \Exception
     */
    private static function make($title = "", $opts = [])
    {
        $image_size = $opts['image_size'];
        $font_size = $opts['font_size'];
        $text_color = $opts['text_color'];
        $background_color = $opts['background_color'];
        $path_to_font = $opts['path_to_font'];

        // Make text magic
        $text = self::parseTitle($title);

        // Extract the dimensions from the target size
        $dimensions = explode('x', $image_size);

        // Generate an image resource with GD
        $imageResource = imagecreate($dimensions[0], $dimensions[1]);

        // Allocate both the background + foreground (text) color
        $allocatedBgColor = self::allocateColor($imageResource, $background_color);
        $allocatedFgColor = self::allocateColor($imageResource, $text_color);

        if ($path_to_font !== null && file_exists($path_to_font)) {
            // Get Bounding Box Size
            $textBox = imagettfbbox($font_size, 0, $path_to_font, $text);

            // Find the outer X and Y values (min and max) and use them to calculate
            // just how wide and high the text box is!
            $xMax = max([$textBox[0], $textBox[2], $textBox[4], $textBox[6]]);
            $xMin = min([$textBox[0], $textBox[2], $textBox[4], $textBox[6]]);
            $textWidth = abs($xMax) - abs($xMin);

            $yMax = max([$textBox[1], $textBox[3], $textBox[5], $textBox[7]]);
            $yMin = min([$textBox[1], $textBox[3], $textBox[5], $textBox[7]]);
            $textHeight = abs($yMax) - abs($yMin);

            // Calculate coordinates of the text
            $x = ((imagesx($imageResource) / 2) - ($textWidth / 2));
            $y = ((imagesy($imageResource) / 2) - ($textHeight / 2));

            imagettftext(
                $imageResource,
                $font_size,
                0,
                $x,
                $y,
                $allocatedFgColor,
                $path_to_font,
                $text
            );

            // Render image
            header('Content-type: image/png');
            echo imagepng($imageResource, null, 0);
            exit;
        } else {
            throw new \Exception("Font not found in given path.");
        }
    }
}

