<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	<h1>News Articles</h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">


					<?php if (!isset($rcnews_search) || $rcnews_search == '') : ?>


						<div class="postbox">

							<div class="handlediv" title="Click to toggle"><br></div>
							<!-- Toggle -->

							<h2 class="hndle"><span>Lets get started</span>
							</h2>

							<div class="inside">

								<form action="" method="post">

									<input type="hidden" name="rcnews_form_submitted" value="Y">

									<table class="form-table">
										<tr valign="top">
											<td scope="row"><label for="tablecell">Search String</label></td>
											<td><input name="rcnews_search" id="rcnews_search" type="text" value="" class="regular-text" /></td>
										</tr>
										<tr valign="top">
											<td scope="row"><label for="tablecell">API Key</label></td>
											<td><input name="rcnews_apikey" id="rcnews_apikey" type="text" value="" class="regular-text" /></td>
										</tr>

									</table>
									<p>
										<input class="button-primary" type="submit" name="rcnews_form_submit" value="Save" />
									</p>

								</form>
							</div>
							<!-- .inside -->

						</div>

					<?php else : ?>
						<!-- .postbox -->


						<div class="postbox">

							<div class="handlediv" title="Click to toggle"><br></div>
							<!-- Toggle -->

							<h2 class="hndle"><span>Lets get started</span></h2>

							<div class="inside">
								<p>Below are the 10 articles</p>

								<ul class="rcnews-articles">

									<?php for ($i = 0; $i < 10; $i++) : ?>
										<li>
											<ul>
												<?php if (count($rcnews_results->{'response'}->{'docs'}[$i]->{'multimedia'}) > 0) : ?>
													<li>
														<img width="120px" src="<?php echo 'http://www.nytimes.com/' . $rcnews_results->{'response'}->{'docs'}[$i]->{'multimedia'}[1]->{'url'} ?>">
													</li>
												<?php endif; ?>

												<li class="rcnews-articles-name">
													<a href="<?php echo $rcnews_results->{'response'}->{'docs'}[$i]->{'web_url'}; ?>">
														<?php echo $rcnews_results->{'response'}->{'docs'}[$i]->{'headline'}->{'main'}; ?>
													</a>
												</li>

												<li class="rcnews-articles-paragraph">
													<p><?php echo $rcnews_results->{'response'}->{'docs'}[$i]->{'lead_paragraph'}; ?></p>
												</li>

											</ul>
										</li>
									<?php endfor; ?>
								</ul>

							</div>
							<!-- .inside -->

						</div>
					<?php endif; ?>
					<!-- .postbox -->

					<div class="postbox">

						<div class="handlediv" title="Click to toggle"><br></div>
						<!-- Toggle -->

						<h2 class="hndle"><span>JSON Feed</span></h2>

						<div class="inside">

							<p>
								<?php echo $rcnews_results->{'response'}->{'docs'}[0]->{'web_url'}; ?>
							</p>
							<p>
								<?php echo $rcnews_results->{'response'}->{'docs'}[0]->{'headline'}->{'main'}; ?>
							</p>
							<p>
								<?php echo $rcnews_results->{'response'}->{'docs'}[0]->{'multimedia'}[1]->{'url'}; ?>
							</p>
							<p>
								<?php echo $rcnews_results->{'response'}->{'docs'}[0]->{'lead_paragraph'}; ?>
							</p>


							<pre><code><?php var_dump($rcnews_results); ?></code></pre>



						</div>

					</div>


					</div>
					<!-- .meta-box-sortables .ui-sortable -->

				</div>
				<!-- post-body-content -->

				<!-- sidebar -->
				<div id="postbox-container-1" class="postbox-container">

					<div class="meta-box-sortables">

						<?php if (isset($rcnews_search) || $rcnews_search != '') : ?>
							<div class="postbox">

								<div class="handlediv" title="Click to toggle"><br></div>
								<!-- Toggle -->

								<h2 class="hndle"><span>Settings</span></h2>

								<div class="inside">

									<form action="" method="post">

										<input type="hidden" name="rcnews_form_submitted" value="Y">
										<p>
											<input name="rcnews_search" id="rcnews_search" type="text" value="<?php echo $rcnews_search; ?>" class="all-options" />
											<input name="rcnews_apikey" id="rcnews_apikey" type="text" value="<?php echo  $rcnews_apikey; ?>" class="all-options" />
										</p>

										<p>
											<input class="button-primary" type="submit" name="rcnews_form_submit" value="Update" />
										</p>

									</form>
								</div>
								<!-- .inside -->

							</div>
						<?php endif; ?>
						<!-- .postbox -->

					</div>
					<!-- .meta-box-sortables -->

				</div>
				<!-- #postbox-container-1 .postbox-container -->

			</div>
			<!-- #post-body .metabox-holder .columns-2 -->

			<br class="clear">
		</div>
		<!-- #poststuff -->

	</div> <!-- .wrap -->