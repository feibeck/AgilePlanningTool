<?php
/**
 * PDF storypage A6 one card.
 *
 * @category  AgilePlanningTool
 * @package   Apt_Pdf_Storypage
 * @author    Tobias Schlüter <tobias.schlueter@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * PDF storypage A6 one card.
 *
 * @category  AgilePlanningTool
 * @package   Apt_Pdf_Storypage
 * @author    Tobias Schlüter <tobias.schlueter@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class Apt_Pdf_Storypage_A6OneCard
{
    const SIZE_A6_ONE_CARD  = '421:297:';

    const CARD_RECTANGLE_X1 = 0;
    const CARD_RECTANGLE_X2 = 421;
    const CARD_RECTANGLE_Y1 = 0;
    const CARD_RECTANGLE_Y2 = 297;

    const HEADER_LINE_X1    = 0;
    const HEADER_LINE_Y1    = 277;
    const HEADER_LINE_X2    = 421;
    const HEADER_LINE_Y2    = 277;

    const NAME_X            = 2;
    const NAME_Y            = 282;

    const STORY_X           = 2;
    const STORY_Y           = 260;

    const ACCEPTANCE_CRIT_X = 2;
    const ACCEPTANCE_CRIT_Y = 211;

    const ESTIMATION_X      = 362;
    const ESTIMATION_Y      = 5;

    const CODE_URL          = "http://chart.apis.google.com/chart?cht=qr&chs=%dx%d&chl=%s&chld=L|0";
    const CODE_SIZE         = 50;
    const CODE_IMAGE_X      = 370;
    const CODE_IMAGE_Y      = 225;

    protected $_page        = null;
    protected $_story       = null;

    public function __construct($story, Zend_Pdf $pdf)
    {
        $this->_story = $story;
        $this->_page  = $pdf->newPage(self::SIZE_A6_ONE_CARD);
    }

    public function getPage()
    {
        $this->_drawBorders();
        $this->_drawName();
        $this->_drawStory();
        $this->_drawAcceptanceCriteria();
        $this->_drawEstimation();
        $this->_drawCode();

        return $this->_page;
    }

    protected function _drawBorders()
    {
        $this->_page->drawRectangle(self::CARD_RECTANGLE_X1, self::CARD_RECTANGLE_Y1,
                                    self::CARD_RECTANGLE_X2, self::CARD_RECTANGLE_Y2,
                                    Zend_Pdf_Page::SHAPE_DRAW_STROKE);

        $this->_page->drawLine(self::HEADER_LINE_X1, self::HEADER_LINE_Y1,
                               self::HEADER_LINE_X2, self::HEADER_LINE_Y2);
    }

    protected function _drawName()
    {
        $this->_page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 16);
        $this->_page->drawText($this->_story->getTitle(), self::NAME_X, self::NAME_Y);
    }

    protected function _drawStory()
    {
        $this->_page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);
        $this->_page->drawText($this->_story->getDescription(), self::STORY_X, self::STORY_Y);
    }

    protected function _drawAcceptanceCriteria()
    {
        $this->_page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);

        $lineHeight = 14;
        $lineY      = self::ACCEPTANCE_CRIT_Y;

        foreach ($this->_story->getCriteria() as $criterion) {
            $this->_page->drawText('- ' . $criterion->getCriterion(), self::ACCEPTANCE_CRIT_X, $lineY);
            $lineY -= $lineHeight;
        }
    }

    protected function _drawEstimation()
    {
        $this->_page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 20);
        $this->_page->drawText($this->_story->getEstimatedPoints(), self::ESTIMATION_X, self::ESTIMATION_Y);
    }

    protected function _drawCode()
    {
        $content = $this->_story->getAbsoluteUrl();

        if (empty($content)) {
            return;
        }
        
        $url       = sprintf(self::CODE_URL, self::CODE_SIZE, self::CODE_SIZE, $content);
        $imageFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'AptStoryCode' . $this->_story->getId() . '.png';
        
        if (false == file_exists($imageFile)) {
            file_put_contents($imageFile, file_get_contents($url));
        }

        try {
            $image = Zend_Pdf_Image::imageWithPath($imageFile);

        } catch (Exception $exception) {
            return;
        }


        $this->_page->drawImage($image,
                                self::CODE_IMAGE_X,
                                self::CODE_IMAGE_Y,
                                self::CODE_IMAGE_X + self::CODE_SIZE,
                                self::CODE_IMAGE_Y + self::CODE_SIZE);
    }
}