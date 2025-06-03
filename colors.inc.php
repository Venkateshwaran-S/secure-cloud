<?php
/**
 * This class can be used to get the most common colors in an image.
 * It needs one parameter: $image, which is the filename of the image you want to process.
 */
class GetMostCommonColors
{
    /**
     * The filename of the image (JPG, GIF, or PNG)
     * @var string
     */
    public $image;

    /**
     * Returns the colors of the image in an array, ordered in descending order
     * @return array Colors with their counts
     * @throws RuntimeException If image processing fails
     */
    public function Get_Color()
    {
        if (empty($this->image)) {
            throw new RuntimeException("No image file specified");
        }

        // Verify image file exists
        if (!file_exists($this->image)) {
            throw new RuntimeException("Image file not found: " . $this->image);
        }

        $size = @getimagesize($this->image);
        if ($size === false) {
            throw new RuntimeException("Invalid image file or unsupported format");
        }

        // Check image dimensions
        if ($size[0] <= 0 || $size[1] <= 0) {
            throw new RuntimeException("Invalid image dimensions");
        }

        // Set preview dimensions
        $PREVIEW_WIDTH = 150;
        $PREVIEW_HEIGHT = 150;
        
        // Calculate scaling factor
        $scale = min($PREVIEW_WIDTH/$size[0], $PREVIEW_HEIGHT/$size[1]);
        $width = ($scale < 1) ? floor($scale*$size[0]) : $size[0];
        $height = ($scale < 1) ? floor($scale*$size[1]) : $size[1];

        // Create resized image
        $image_resized = imagecreatetruecolor($width, $height);
        if ($image_resized === false) {
            throw new RuntimeException("Failed to create image resource");
        }

        // Load original image based on type
        try {
            switch ($size[2]) {
                case IMAGETYPE_GIF:
                    $image_orig = imagecreatefromgif($this->image);
                    break;
                case IMAGETYPE_JPEG:
                    $image_orig = imagecreatefromjpeg($this->image);
                    break;
                case IMAGETYPE_PNG:
                    $image_orig = imagecreatefrompng($this->image);
                    break;
                default:
                    throw new RuntimeException("Unsupported image type");
            }

            if ($image_orig === false) {
                throw new RuntimeException("Failed to create image from file");
            }

            // Resize the image
            if (!imagecopyresampled($image_resized, $image_orig, 0, 0, 0, 0, $width, $height, $size[0], $size[1])) {
                throw new RuntimeException("Failed to resize image");
            }

            // Process colors
            $hexarray = $this->processImageColors($image_resized);
            
            // Clean up resources
            imagedestroy($image_orig);
            imagedestroy($image_resized);

            return $hexarray;
            
        } catch (Exception $e) {
            // Clean up if something went wrong
            if (isset($image_orig)) imagedestroy($image_orig);
            if (isset($image_resized)) imagedestroy($image_resized);
            throw $e;
        }
    }

    /**
     * Process image colors and return hex values with counts
     * @param resource $im Image resource
     * @return array Color hex values with counts
     */
    private function processImageColors($im)
    {
        $hexarray = array();
        $imgWidth = imagesx($im);
        $imgHeight = imagesy($im);

        for ($y = 0; $y < $imgHeight; $y++) {
            for ($x = 0; $x < $imgWidth; $x++) {
                $index = imagecolorat($im, $x, $y);
                $Colors = imagecolorsforindex($im, $index);
                
                // Round colors to reduce nearly duplicate colors
                $Colors['red'] = intval((($Colors['red']) + 15) / 32) * 32;
                $Colors['green'] = intval((($Colors['green']) + 15) / 32) * 32;
                $Colors['blue'] = intval((($Colors['blue']) + 15) / 32) * 32;
                
                // Clamp values to 240 max
                $Colors['red'] = min($Colors['red'], 240);
                $Colors['green'] = min($Colors['green'], 240);
                $Colors['blue'] = min($Colors['blue'], 240);
                
                $hex = substr("0" . dechex($Colors['red']), -2) . 
                       substr("0" . dechex($Colors['green']), -2) . 
                       substr("0" . dechex($Colors['blue']), -2);
                
                $hexarray[] = $hex;
            }
        }

        $hexarray = array_count_values($hexarray);
        natsort($hexarray);
        return array_reverse($hexarray, true);
    }
}
?>