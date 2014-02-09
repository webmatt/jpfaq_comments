<?php
namespace Comnerds\JpfaqComments\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Benjamin Kott <info@bk2k.info>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * @author Benjamin Kott <info@bk2k.info>
 */
class ImageViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Uri\ImageViewHelper {
    
    /**
     * @param string $src
     * @param string $width
     * @param string $height
     * @param integer $minWidth
     * @param integer $minHeight
     * @param integer $maxWidth
     * @param integer $maxHeight
     * @param boolean $absolute
     */
    public function render($src, $width = NULL, $height = NULL, $minWidth = NULL, $minHeight = NULL, $maxWidth = NULL, $maxHeight = NULL, $absolute = FALSE) {
        $imageSource = parent::render($src, $width, $height, $minWidth, $minHeight, $maxWidth, $maxHeight);
        if($absolute && TYPO3_MODE === 'FE'){
            $baseUri = $this->controllerContext->getRequest()->getBaseUri();
            error_log($baseUri);
            $prefix = $GLOBALS['TSFE']->absRefPrefix;
            error_log($prefix);
            if ($prefix && ($pos = strrpos($baseUri, $prefix)) !== FALSE)
            {
                $baseUri = substr($baseUri, 0, $pos);
            }
            error_log($baseUri);
            $imageSource = $baseUri . $imageSource;
            error_log($imageSource);
        }
        return $imageSource;
    }
    
}

?>
