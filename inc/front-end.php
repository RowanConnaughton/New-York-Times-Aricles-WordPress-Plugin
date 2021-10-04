<?php 

	echo $before_widget;
	echo $before_title . $title . $after_title;


?>
<ul class="rcnews-articles frontend">

	<?php 

		$total_articles = count( $rcnews_results->{'response'}->{'docs'} );

		for( $i = $total_articles - 1; $i >= $total_articles - $num_articles; $i-- ):		

	;?>

	<li class="rcnews-articles">

			<div class="rcnews-articles-info">
				<?php if( $display_image == '1' ): ?>

					<?php if( count($rcnews_results->{'response'}->{'docs'}[$i]->{'multimedia'}) > 0): ?>
				
					<img width="120px" src="<?php echo "http://www.nytimes.com/" . $rcnews_results->{'response'}->{'docs'}[$i]->{'multimedia'}[1]->{'url'}; ?>">	

					<?php endif; ?>	
				
				<?php endif; ?>														
				
				<p class="rcnews-articles-name">			
					<a href="<?php echo $rcnews_results->{'response'}->{'docs'}[$i]->{'web_url'}; ?>">
						<?php echo $rcnews_results->{'response'}->{'docs'}[$i]->{'headline'}->{'main'}; ?>
					</a>								
				</p>							
				
				<p>
					<?php echo $rcnews_results->{'response'}->{'docs'}[$i]->{'lead_paragraph'}; ?>
				</p>							

			</div>

	</li>


	<?php endfor; ?>

</ul>

<?php 
	echo $after_widget;
?>