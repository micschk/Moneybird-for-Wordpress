<div class="custom_subitems">
	<?php if(count($subitems->posts) > 0) : ?>
	<table>
		<tr>
			<td style="text-align:left; padding-right:10px;">Moneybird klantnr.</td>
			<td style="text-align:left; padding-right:10px;">Bedrijfsnaam</td>
			<td style="text-align:left; padding-right:10px;">Email</td>
			<td style="text-align:left; padding-right:10px;">Telefoonnummer</td>
			<td style="text-align:left; padding-right:10px;">Postcode</td>
			<td style="text-align:left; padding-right:10px;">Website</td>
		</tr>
		<?php foreach($subitems->posts as $subitem) : ?>
			<?php $meta = get_post_custom($subitem->ID); ?>
		<tr>
			<td style="text-align:left; padding-right:10px;">
				<?php $moneybird = $meta['moneybird'][0]; if(!$moneybird) : $moneybird = 'Geen klantid'; endif; ?>
				<a href="/wp-admin/post.php?post=<?php echo $subitem->ID ?>&action=edit"><?php echo $moneybird; ?></a>
			</td>
			<td>
				<?=$meta['bedrijf'][0]?>
			</td>
			<td>
				<a href="mailto:<?php echo $meta['email'][0]; ?>"><?=$meta['email'][0]?></a>
			</td>
			<td>
				<?=$meta['telefoon'][0]?>
			</td>
			<td>
				<?=$meta['postcode'][0]?>
			</td>
			<td>
				<?php $website = $meta['website'][0]; if(!$website) : echo '-'; else : ?>
					<a href="http://<?=$meta['website'][0]?>" target="_blank"><?=$meta['website'][0]?></a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php else : ?>
	<p>Er zijn nog geen geregistreerde bedrijven.</p>
	<?php endif; ?>
</div>