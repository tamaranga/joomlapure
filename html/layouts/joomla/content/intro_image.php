<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
// Include the seo config file
$app = JFactory::getApplication();
$template = $app->getTemplate();
include (JPATH_BASE.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$template.DIRECTORY_SEPARATOR.'pure'.DIRECTORY_SEPARATOR.'config.php');
if ($imageResizeTeaser && !class_exists('resize')) {
	include_once (JPATH_BASE.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$template.DIRECTORY_SEPARATOR.'pure'.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'function.resize.php');
}
?>
<?php $images = json_decode($displayData->images); ?>
<?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>
	<?php $imgfloat = (empty($images->float_intro)) ? $displayData->params->get('float_intro') : $images->float_intro; ?>
	<div class="pull-<?php echo htmlspecialchars($imgfloat); ?> item-image"> <img
		<?php if ($images->image_intro_caption):
		echo 'class="caption"'.' title="' .htmlspecialchars($images->image_intro_caption) .'"';
		endif; ?>
		<?php if ($imageResizeTeaser) {
			$settings = array();
			if ($imageWidthTeaser) {$settings['w'] = $imageWidthTeaser;}
			if ($imageHeightTeaser) {$settings['h'] = $imageHeightTeaser;}
			if ($imageCropTeaser == 1) {$settings['crop'] = 'true';}
			if ($imageScaleTeaser == 1) {$settings['scale'] = 'true';}
			if ($canvasColor) {$settings['canvas-color'] = $canvasColor;}
			if ($imageUseFeatured) {
				$original = $images->image_fulltext;
				$images->image_intro = resize($images->image_fulltext,$settings);
			} else {
				$original = $images->image_intro;
				$images->image_intro = resize($images->image_intro,$settings);
			}
		} ?>
		src="<?php if ($cdnUrl && $cdnFeaturedImages) {echo $cdnUrl.'/'.ltrim(htmlspecialchars($images->image_intro), '/');} else echo htmlspecialchars($images->image_intro); ?>" <?php if ($imageResizeTeaser && $original) echo 'data-original="'.$original.'"'; ?> alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/> </div>
	<?php endif; ?>
