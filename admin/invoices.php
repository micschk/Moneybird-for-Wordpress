<div class="custom_subitems">
	<?php if(count($subitems->posts) > 0) { ?>
	<table>
		<tr>
			<td style="text-align:left; padding-right:10px;">&nbsp;</td>
			<td style="text-align:left; padding-right:10px;">Factuurnummer</td>
			<td style="text-align:left; padding-right:10px;">Online factuur</td>
			<td style="text-align:left; padding-right:10px;">Bedrijf</td>
			<td style="text-align:left; padding-right:10px;">Bedrag (ex. btw)</td>
			<td style="text-align:left; padding-right:10px;">Betaald</td>
		</tr>
		<?php foreach($subitems->posts as $subitem) { ?>
			<?php $meta = get_post_custom($subitem->ID); ?>
		<tr>
			<td style="text-align:left; padding-right:10px;">
				<?php echo mysql2date('d M Y', $subitem->post_date);?>
			</td>
			<td style="text-align:left; padding-right:10px;">
				<a href="/wp-admin/post.php?post=<?=$subitem->ID?>&action=edit" target="_blank"><?php if($meta['moneybird_factuur_nummer'][0]) : ?><?=$meta['moneybird_factuur_nummer'][0]?><?php else : ?>Draft<?php endif; ?></a>
			</td>
			<td>
				<?php
				
				if($meta['moneybird_factuur_online'][0]) :
					echo '<a href="'.$meta['moneybird_factuur_online'][0].'" target="_blank">Bekijk factuur</a>';
				else :
					echo 'Nog geen factuur beschikbaar';
				endif;
				
				?>	
			</td>
			<td>
				<?php
					$company_id = get_post_meta( $subitem->ID , 'company' , true );
					$company   = wp_get_single_post($company_id);
					echo '<a href="/wp-admin/post.php?post='.$company_id.'&action=edit" target="_blank">'.$company->post_title.'</a>'; 
				?>
			</td>
			<td>
				<?php
					$amount 	 = $meta['price'][0];
					echo '&euro; '.$amount; 
				?>
			</td>
			<td>
				<?php
					$paid = $meta['paid'][0];
					if($paid == 'Nee' || $paid == '') : echo '<span style="color:red;">Niet betaald</span>'; else : echo '<span style="color:green;">Betaald</span>'; endif;
				?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php } else { ?>
	<p>Er zijn nog geen facturen aangemaakt.</p>
	<?php } ?>
</div>