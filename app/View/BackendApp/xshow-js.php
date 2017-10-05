<div id="header">
			<a href="<?php echo $mater; ?>" target="_blank"><img id="logo" alt="logo" src="/assets/img/logo.png"/></a>
		</div
		><div id="big-one"
			><img id="focus" class="fitbox big" src="<?php echo $focusedPicture['src']; ?>"
		/></div
		><div id="test-pager-strip" data-count="<?php echo count($triagedPictures); ?>" data-order="<?php echo $focusOrderNum; ?>" data-triage-left="<?php echo $triageCfg['left']; ?>" data-triage-right="<?php echo $triageCfg['right']; ?>"
<?php if (isset($prevId)): ?>
					><a href="/xfocus-js/<?php echo $propertyId; ?>/<?php echo $prevId; ?>"><img id="left" class="navigation small enabled" src="/assets/img/left2.png" data-show="/assets/img/left2.png" data-hide="/assets/img/user-select-none.png"/></a
<?php else: ?>
					><a data-href="/xfocus-js/<?php echo $propertyId; ?>/{prevId}"><img id="left" class="navigation small" src="/assets/img/user-select-none.png" data-show="/assets/img/left2.png" data-hide="/assets/img/user-select-none.png"/></a
<?php endif; ?>
	<?php foreach ($triagedPictures as $i => $triagedPicture): ?>
	<?php if ($triagedPicture[0] == 'focus'): ?>
					><a class="slide focus" data-order="<?php echo $i; ?>" data-href="/xfocus-js/<?php echo $propertyId; ?>/<?php echo $pictureId; ?>"><img id="focus-small" class="fitbox" data-dbid="<?php echo $triagedPicture[1]['id']; ?>" src="<?php echo $triagedPicture[1]['src']; ?>"/></a
	<?php else: ?>
					><a class="slide <?php echo $triagedPicture[0]; ?>" data-order="<?php echo $i; ?>" href="/xfocus-js/<?php echo $propertyId; ?>/<?php echo $triagedPicture[1]['id']; ?>"><img class="fitbox small" data-dbid="<?php echo $triagedPicture[1]['id']; ?>" src="<?php echo $triagedPicture[1]['src']; ?>"/></a
	<?php endif; ?>
	<?php endforeach; ?>
<?php if (isset($nextId)): ?>
					><a href="/xfocus-js/<?php echo $propertyId; ?>/<?php echo $nextId; ?>"><img id="right" class="navigation small enabled" src="/assets/img/right2.png" data-show="/assets/img/right2.png" data-hide="/assets/img/user-select-none.png"/></a
<?php else: ?>
					><a data-href="/xfocus-js/<?php echo $propertyId; ?>/{nextId}"><img id="right" class="navigation small" src="/assets/img/user-select-none.png" data-show="/assets/img/right2.png" data-hide="/assets/img/user-select-none.png"/></a
<?php endif; ?>
		></div>
