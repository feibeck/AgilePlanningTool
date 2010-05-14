<?php
/**
 * PDF story.
 * 
 * Generates PDF story cards.
 *
 * @category  AgilePlanningTool
 * @package   Apt_Pdf_Story
 * @author    Tobias Schlüter <tobias.schlueter@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * PDF story.
 * 
 * Generates PDF story cards.
 * 
 * @category  AgilePlanningTool
 * @package   Apt_Pdf_Story
 * @author    Tobias Schlüter <tobias.schlueter@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class Apt_Pdf_Story
{
    protected $_pdf            = null;
    
    protected $_stories        = array();
    
    public function __construct(Zend_Pdf $pdf)
    {
        $this->_pdf = $pdf;
    }
        
    public function setStories($stories)
    {
        $this->_stories = $stories;
    }
    
    public function addStory($story)
    {
        $this->_stories[] = $story;
    }
    
    protected function _storiesToPdf()
    {
        foreach ($this->_stories as $story) {
            $storypage = new Apt_Pdf_Storypage_A6OneCard($story, $this->_pdf);
            $this->_pdf->pages[] = $storypage->getPage();
        } 
    }
    
    public function render()
    {
        $this->_storiesToPdf();
        
        return $this->_pdf->render();
    }
}