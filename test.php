<div>
	<?php if ($mutual) :?>
	<h3>Mututal friends</h3>
		<ul>
			<?php foreach($mutual as $friend) : ?>
				<li><a href='members.php?view=<?=$friend?>'><?=$friend?></a>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>



	<?php if ($following) :?>
	<h3><?=name3?> following</h3>
		<ul>
			<?php foreach($followers as $friend) : ?>
				<li><a href='members.php?view=<?=$friend?>'><?=$friend?></a>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>


</div>


<?php require 'footer.php'; ?>
