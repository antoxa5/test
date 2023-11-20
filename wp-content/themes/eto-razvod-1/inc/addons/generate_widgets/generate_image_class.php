<?php

class GenerateImageClass {
    private $userId;
    private $postId;
    public $rating;
    public $reviewsCount;
    private $image;
    private $font;
    private $fontBold;
    private $width;
    private $height;
    private $imgEtorazvod;
    private $dir;
    private $comp_id;

    public function __construct($comp_id) {
//        $this->userId = $userId;
//        $this->dir = TEMPLATEPATH . "/inc/addons/generate_widgets/images/company/";
        $this->comp_id = $comp_id;
        $this->dir = $_SERVER['DOCUMENT_ROOT'] . "/icompany/";
        $this->initializeRating();
    }

    private function initializeRating() {
        $current_user_for_rating = wp_get_current_user();
        $this->userId = $current_user_for_rating->data->ID;

        $company_id_for_rating = get_field('comp_statuses', 'user_' . $this->userId);
        $company_id_for_rating = is_array($company_id_for_rating) ? $company_id_for_rating : array();
        
//        foreach ($company_id_for_rating as $value) {
//            if($value['company_user'][0] == $this->comp_id){
//                $c_id = 
//            }
//        }
//        
//        print_r($company_id_for_rating);

        $this->postId = $this->comp_id;
//        $this->postId = $company_id_for_rating[0]['company_user'][0];
        $this->rating = get_field('reviews_rating_average', $this->postId);
        $this->reviewsCount = get_field('reviews_count_reviews', $this->postId);

//        $this->font = TEMPLATEPATH . "/inc/addons/generate_widgets/fonts/Stem-ExtraLight.ttf";
        $this->font = TEMPLATEPATH . "/inc/addons/generate_widgets/fonts/Stem-Light.ttf";
        $this->fontBold = TEMPLATEPATH . "/inc/addons/generate_widgets/fonts/Stem-Bold.ttf";
        $this->imgEtorazvod = imagecreatefrompng(TEMPLATEPATH . "/inc/addons/generate_widgets/images/etorazvod.png");
    }

    public function createImage($width = 278, $height = 190) {
        $this->width = $width;
        $this->height = $height;

        $this->image = imagecreatetruecolor($this->width, $this->height);
        $col = imagecolorallocate($this->image, 255, 255, 255);
        imagefill($this->image, 0, 0, $col);

        imagecopy($this->image, $this->imgEtorazvod, 30, 25, 0, 0, 97, 38);

        $this->setRatingStars();
        $this->addText();
    }

    private function setRatingStars() {
        $fullStarImage = imagecreatefrompng(TEMPLATEPATH . "/inc/addons/generate_widgets/images/icon_rating_full.png");
        $halfStarImage = imagecreatefrompng(TEMPLATEPATH . "/inc/addons/generate_widgets/images/icon_rating_hulf.png");
        $emptyStarImage = imagecreatefrompng(TEMPLATEPATH . "/inc/addons/generate_widgets/images/icon_rating_empty.png");

        for ($i = 0; $i < 5; $i++) {
            if ($this->rating > $i) {
                $starImage = ($this->rating <= $i + 0.5) ? $halfStarImage : $fullStarImage;
            } else {
                $starImage = $emptyStarImage;
            }
            imagecopy($this->image, $starImage, 30 + ($i * 45), 80, 0, 0, 40, 40);
        }
    }

    private function addText() {
        $otstup = 47;
//        if($this->rating == 0 || strlen($this->rating) > 1){
        if($this->rating == 0 || $this->rating == 1 || $this->rating == 2 || $this->rating == 3 || $this->rating == 4 || $this->rating == 5){
            $otstup = 65;
        }
        $color = imagecolorallocate($this->image, 0, 0, 0);
        imagefttext($this->image, 16, 0, 85, 150, $color, $this->font, " |  " . $this->reviewsCount . $this->countedText($this->reviewsCount, __(' отзыв', 'er_theme'), __(' отзыва', 'er_theme'), __(' отзывов', 'er_theme')));
        imagefttext($this->image, 16, 0, $otstup, 150, $color, $this->fontBold, round($this->rating, 1));
    }

    public function countedText($count, $singular, $few, $many) {
        if ($count == 1) {
            return $singular;
        } elseif ($count > 1 && $count < 5) {
            return $few;
        } else {
            return $many;
        }
    }

    public function saveImage() {
        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0755, true);
        }

        imagepng($this->image, $this->dir . $this->postId . '.png');
//        imagedestroy($this->image);
    }
    
    public function outputImage() {
        ob_start();
        imagepng($this->image);
        $outputBuffer = ob_get_clean();
        $base64 = base64_encode($outputBuffer);
        return '<div class="div_widget_small" style="display: flex;"><img style="flex-grow: 1; max-width: 300px;" src="data:image/jpeg;base64,' . $base64 . '" /></div>';
        imagedestroy($this->image);
        
    }
}

// Использование класса
//$casinoRating = new GenerateImageClass($user_id);
//$casinoRating->createImage();
//$casinoRating->saveImage('your_image_name');
