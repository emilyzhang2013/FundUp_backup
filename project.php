<?php
session_start();
require_once ('include/header.html');
require_once ('include/dbconfig.php');
require_once ('include/helpfulFunctions.php');
$pid = $_GET['pid'];
$pdo = db_connect();
$stmt = $pdo -> prepare(
        "Select pid, pname, pdescription, pOwner, tags, Date(projectCreatedTime) createT, Date(endFundTime) endFT,
                          Date(completionDate) endPT, minFund, maxFund, fundSoFar, pstatus, cover
                   From Project
                   WHERE pid = :pid"
);
$stmt -> execute([':pid' => $pid]);
$project = $stmt -> fetch();

$stmt = $pdo -> prepare (
        "select *
                   from ProjectDetails
                   where pid = :pid
                   order by updateTime desc"
);
$stmt -> execute([':pid' => $pid]);
$projectUpdates = $stmt -> fetchAll();

// Made Changes
$stmt = $pdo -> prepare(
        "Select tags
                   From Project
                   WHERE pid = :pid"
);
$stmt -> execute([':pid' => $pid]);
$result = $stmt -> fetch();

function displaytags($record){
    $tags = $record['tags'];
    $tagsArray = explode(",", $tags);
    echo "
    <!-- Tag Cloud -->
    
    <div class='tagcloud clearfix bottommargin'>";
        foreach($tagsArray as $row) {
            echo "<a href='projectbucket.php?tag=$row'>$row</a>";//TODO
        }
    echo "
    </div><!-- .tagcloud end -->
    ";
}
?>


		<!-- Page Title
		============================================= -->
		<section id="page-title">

			<div class="container clearfix">
			</div>

		</section><!-- #page-title end -->

		<!-- Content
		============================================= -->
		<section id="content">

			<div class="content-wrap">

				<div class="container clearfix">

					<!-- Post Content
					============================================= -->
					<div class="postcontent nobottommargin clearfix">

						<div class="single-post nobottommargin">

							<!-- Single Post
							============================================= -->
							<div class="entry clearfix">

								<!-- Entry Title
								============================================= -->
								<div class="entry-title">
									<h2><?php echo $project['pname']?></h2>
								</div><!-- .entry-title end -->

								<!-- Entry Meta
								============================================= -->
								<ul class="entry-meta clearfix">
									<li><i class="icon-calendar3"></i>End in <?php echo $project['endFundTime']?></li>
									<li><a href="#"><i class="icon-user"></i> admin</a></li>
									<li><i class="icon-folder-open"></i> <a href="#">General</a>, <a href="#">Media</a></li>
									<li><a href="#"><i class="icon-comments"></i> 43 Comments</a></li>
									<li><a href="#"><i class="icon-camera-retro"></i></a></li>
								</ul><!-- .entry-meta end -->

								<!-- Entry Image
								============================================= -->
								<div class="entry-image">
									<a href="#"><img src='projectimage.php?pid=<?php echo $pid; ?>' alt="Blog Single"></a>
								</div><!-- .entry-image end -->

								<!-- Entry Content
								============================================= -->
								<div class="entry-content notopmargin">
                                    <h4>Description</h4>
                                    <p><?php echo $project['pdescription'];?></p>
                                    <?php
                                    if (isset($projectUpdates)) {
                                        echo "<h4>Update</h4>";
                                        foreach ($projectUpdates as $row) {
                                            $updateTime = $row['updateTime'];
                                            $updateDescription = $row['updateDescription'];
                                            $updateTimeDisplay = date_format(date_create($updateTime), 'Y-m-d h:m:s');
                                            echo "<i class='icon-calendar3'></i>Update at $updateTimeDisplay";
                                            echo "<img src='projectimage.php?pid=$pid&updateTime=$updateTime' alt='Blog Single''>";
                                            echo "<p>$updateDescription</p>";
                                            echo "<div class='divider divider-border'><i class='icon-refresh'></i></div>";
                                        }
                                    }
                                    ?>
									<!-- Post Single - Content End -->

									<div class="clear"></div>

									<!-- Post Single - Share
									============================================= -->
									<div class="si-share noborder clearfix">
										<span>Share this Post:</span>
										<div>
											<a href="#" class="social-icon si-borderless si-facebook">
												<i class="icon-facebook"></i>
												<i class="icon-facebook"></i>
											</a>
											<a href="#" class="social-icon si-borderless si-twitter">
												<i class="icon-twitter"></i>
												<i class="icon-twitter"></i>
											</a>
											<a href="#" class="social-icon si-borderless si-pinterest">
												<i class="icon-pinterest"></i>
												<i class="icon-pinterest"></i>
											</a>
											<a href="#" class="social-icon si-borderless si-gplus">
												<i class="icon-gplus"></i>
												<i class="icon-gplus"></i>
											</a>
											<a href="#" class="social-icon si-borderless si-rss">
												<i class="icon-rss"></i>
												<i class="icon-rss"></i>
											</a>
											<a href="#" class="social-icon si-borderless si-email3">
												<i class="icon-email3"></i>
												<i class="icon-email3"></i>
											</a>
										</div>
									</div><!-- Post Single - Share End -->

								</div>
							</div><!-- .entry end -->

							<!-- Post Navigation
							============================================= -->
							<div class="post-navigation clearfix">

								<div class="col_half nobottommargin">
									<a href="#">&lArr; This is a Standard post with a Slider Gallery</a>
								</div>

								<div class="col_half col_last tright nobottommargin">
									<a href="#">This is an Embedded Audio Post &rArr;</a>
								</div>

							</div><!-- .post-navigation end -->

							<div class="line"></div>

							<!-- Post Author Info
							============================================= -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Posted by <span><a href="#">John Doe</a></span></h3>
								</div>
								<div class="panel-body">
									<div class="author-image">
										<img src="images/author/1.jpg" alt="" class="img-circle">
									</div>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores, eveniet, eligendi et nobis neque minus mollitia sit repudiandae ad repellendus recusandae blanditiis praesentium vitae ab sint earum voluptate velit beatae alias fugit accusantium laboriosam nisi reiciendis deleniti tenetur molestiae maxime id quaerat consequatur fugiat aliquam laborum nam aliquid. Consectetur, perferendis?
								</div>
							</div><!-- Post Single - Author End -->

							<div class="line"></div>

							<h4>Related Posts:</h4>

							<div class="related-posts clearfix">

								<div class="col_half nobottommargin">

									<div class="mpost clearfix">
										<div class="entry-image">
											<a href="#"><img src="images/blog/small/10.jpg" alt="Blog Single"></a>
										</div>
										<div class="entry-c">
											<div class="entry-title">
												<h4><a href="#">This is an Image Post</a></h4>
											</div>
											<ul class="entry-meta clearfix">
												<li><i class="icon-calendar3"></i> 10th July 2014</li>
												<li><a href="#"><i class="icon-comments"></i> 12</a></li>
											</ul>
											<div class="entry-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia nisi perferendis.</div>
										</div>
									</div>

									<div class="mpost clearfix">
										<div class="entry-image">
											<a href="#"><img src="images/blog/small/20.jpg" alt="Blog Single"></a>
										</div>
										<div class="entry-c">
											<div class="entry-title">
												<h4><a href="#">This is a Video Post</a></h4>
											</div>
											<ul class="entry-meta clearfix">
												<li><i class="icon-calendar3"></i> 24th July 2014</li>
												<li><a href="#"><i class="icon-comments"></i> 16</a></li>
											</ul>
											<div class="entry-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia nisi perferendis.</div>
										</div>
									</div>

								</div>

								<div class="col_half nobottommargin col_last">

									<div class="mpost clearfix">
										<div class="entry-image">
											<a href="#"><img src="images/blog/small/21.jpg" alt="Blog Single"></a>
										</div>
										<div class="entry-c">
											<div class="entry-title">
												<h4><a href="#">This is a Gallery Post</a></h4>
											</div>
											<ul class="entry-meta clearfix">
												<li><i class="icon-calendar3"></i> 8th Aug 2014</li>
												<li><a href="#"><i class="icon-comments"></i> 8</a></li>
											</ul>
											<div class="entry-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia nisi perferendis.</div>
										</div>
									</div>

									<div class="mpost clearfix">
										<div class="entry-image">
											<a href="#"><img src="images/blog/small/22.jpg" alt="Blog Single"></a>
										</div>
										<div class="entry-c">
											<div class="entry-title">
												<h4><a href="#">This is an Audio Post</a></h4>
											</div>
											<ul class="entry-meta clearfix">
												<li><i class="icon-calendar3"></i> 22nd Aug 2014</li>
												<li><a href="#"><i class="icon-comments"></i> 21</a></li>
											</ul>
											<div class="entry-content">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia nisi perferendis.</div>
										</div>
									</div>

								</div>

							</div>

							<!-- Comments
							============================================= -->
							<div id="comments" class="clearfix">

								<h3 id="comments-title"><span>3</span> Comments</h3>

								<!-- Comments List
								============================================= -->
								<ol class="commentlist clearfix">

									<li class="comment even thread-even depth-1" id="li-comment-1">

										<div id="comment-1" class="comment-wrap clearfix">

											<div class="comment-meta">

												<div class="comment-author vcard">

													<span class="comment-avatar clearfix">
													<img alt='' src='http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60' class='avatar avatar-60 photo avatar-default' height='60' width='60' /></span>

												</div>

											</div>

											<div class="comment-content clearfix">

												<div class="comment-author">John Doe<span><a href="#" title="Permalink to this comment">April 24, 2012 at 10:46 am</a></span></div>

												<p>Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Nullam id dolor id nibh ultricies vehicula ut id elit. Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</p>

												<a class='comment-reply-link' href='#'><i class="icon-reply"></i></a>

											</div>

											<div class="clear"></div>

										</div>


										<ul class='children'>

											<li class="comment byuser comment-author-_smcl_admin odd alt depth-2" id="li-comment-3">

												<div id="comment-3" class="comment-wrap clearfix">

													<div class="comment-meta">

														<div class="comment-author vcard">

															<span class="comment-avatar clearfix">
															<img alt='' src='http://1.gravatar.com/avatar/30110f1f3a4238c619bcceb10f4c4484?s=40&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D40&amp;r=G' class='avatar avatar-40 photo' height='40' width='40' /></span>

														</div>

													</div>

													<div class="comment-content clearfix">

														<div class="comment-author"><a href='#' rel='external nofollow' class='url'>SemiColon</a><span><a href="#" title="Permalink to this comment">April 25, 2012 at 1:03 am</a></span></div>

														<p>Nullam id dolor id nibh ultricies vehicula ut id elit.</p>

														<a class='comment-reply-link' href='#'><i class="icon-reply"></i></a>

													</div>

													<div class="clear"></div>

												</div>

											</li>

										</ul>

									</li>

									<li class="comment byuser comment-author-_smcl_admin even thread-odd thread-alt depth-1" id="li-comment-2">

										<div id="comment-2" class="comment-wrap clearfix">

											<div class="comment-meta">

												<div class="comment-author vcard">

													<span class="comment-avatar clearfix">
													<img alt='' src='http://1.gravatar.com/avatar/30110f1f3a4238c619bcceb10f4c4484?s=60&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D60&amp;r=G' class='avatar avatar-60 photo' height='60' width='60' /></span>

												</div>

											</div>

											<div class="comment-content clearfix">

												<div class="comment-author"><a href='http://themeforest.net/user/semicolonweb' rel='external nofollow' class='url'>SemiColon</a><span><a href="#" title="Permalink to this comment">April 25, 2012 at 1:03 am</a></span></div>

												<p>Integer posuere erat a ante venenatis dapibus posuere velit aliquet.</p>

												<a class='comment-reply-link' href='#'><i class="icon-reply"></i></a>

											</div>

											<div class="clear"></div>

										</div>

									</li>

								</ol><!-- .commentlist end -->

								<div class="clear"></div>

								<!-- Comment Form
								============================================= -->
								<div id="respond" class="clearfix">

									<h3>Leave a <span>Comment</span></h3>

									<form class="clearfix" action="#" method="post" id="commentform">

										<div class="col_one_third">
											<label for="author">Name</label>
											<input type="text" name="author" id="author" value="" size="22" tabindex="1" class="sm-form-control" />
										</div>

										<div class="col_one_third">
											<label for="email">Email</label>
											<input type="text" name="email" id="email" value="" size="22" tabindex="2" class="sm-form-control" />
										</div>

										<div class="col_one_third col_last">
											<label for="url">Website</label>
											<input type="text" name="url" id="url" value="" size="22" tabindex="3" class="sm-form-control" />
										</div>

										<div class="clear"></div>

										<div class="col_full">
											<label for="comment">Comment</label>
											<textarea name="comment" cols="58" rows="7" tabindex="4" class="sm-form-control"></textarea>
										</div>

										<div class="col_full nobottommargin">
											<button name="submit" type="submit" id="submit-button" tabindex="5" value="Submit" class="button button-3d nomargin">Submit Comment</button>
										</div>

									</form>

								</div><!-- #respond end -->

							</div><!-- #comments end -->

						</div>

					</div><!-- .postcontent end -->

					<!-- Sidebar
					============================================= -->
					<div class="sidebar col_last clearfix">
						<div class="sidebar-widgets-wrap">

                            <div class="widget clearfix">

                                <h4>Project bio</h4>
                                <div class="portfolio-desc">
                                    <ul class="iconlist">
                                        <li><i class="icon-ok"></i> <strong>Created:</strong> <?php echo $project['createT']?></li>
                                        <li><i class="icon-remove"></i> <strong>End Fund:</strong> <?php echo $project['endFT']?></li>
                                        <li><i class="icon-remove"></i> <strong>Complete:</strong> <?php echo $project['endPT']?></li>
                                        <li><i class="icon-ok"></i> <strong>Collected:</strong> <?php echo '$'.$project['fundSoFar']?></li>
                                        <li><i class="icon-ok"></i> <strong>By:</strong> <?php $pOname = $project['pOwner']; echo "<a href='user.php?username=$pOname'>$pOname</a>" ?></li>
                                    </ul>

                                    <?php
                                    displaytags($result);
                                    ?>


                                    <?php
                                    if ($_SESSION['username'] == $project['pOwner']) {
                                        echo "<a href='updateProject.php?pid=$pid' class='button button-3d button-rounded button-teal'>Update your project</a>";
                                    }
                                    ?>

                                </div>
                            </div>

							<div class="widget widget-twitter-feed clearfix">

								<h4>Twitter Feed</h4>
								<ul class="iconlist twitter-feed" data-username="envato" data-count="2">
									<li></li>
								</ul>

								<a href="#" class="btn btn-default btn-sm fright">Follow Us on Twitter</a>

							</div>

							<div class="widget clearfix">

								<div class="tabs nobottommargin clearfix" id="sidebar-tabs">

									<ul class="tab-nav clearfix">
										<li><a href="#tabs-1">Popular</a></li>
										<li><a href="#tabs-2">Recent</a></li>
										<li><a href="#tabs-3"><i class="icon-comments-alt norightmargin"></i></a></li>
									</ul>

									<div class="tab-container">

										<div class="tab-content clearfix" id="tabs-1">
											<div id="popular-post-list-sidebar">

												<div class="spost clearfix">
													<div class="entry-image">
														<a href="#" class="nobg"><img class="img-circle" src="images/magazine/small/3.jpg" alt=""></a>
													</div>
													<div class="entry-c">
														<div class="entry-title">
															<h4><a href="#">Debitis nihil placeat, illum est nisi</a></h4>
														</div>
														<ul class="entry-meta">
															<li><i class="icon-comments-alt"></i> 35 Comments</li>
														</ul>
													</div>
												</div>

												<div class="spost clearfix">
													<div class="entry-image">
														<a href="#" class="nobg"><img class="img-circle" src="images/magazine/small/2.jpg" alt=""></a>
													</div>
													<div class="entry-c">
														<div class="entry-title">
															<h4><a href="#">Elit Assumenda vel amet dolorum quasi</a></h4>
														</div>
														<ul class="entry-meta">
															<li><i class="icon-comments-alt"></i> 24 Comments</li>
														</ul>
													</div>
												</div>

												<div class="spost clearfix">
													<div class="entry-image">
														<a href="#" class="nobg"><img class="img-circle" src="images/magazine/small/1.jpg" alt=""></a>
													</div>
													<div class="entry-c">
														<div class="entry-title">
															<h4><a href="#">Lorem ipsum dolor sit amet, consectetur</a></h4>
														</div>
														<ul class="entry-meta">
															<li><i class="icon-comments-alt"></i> 19 Comments</li>
														</ul>
													</div>
												</div>

											</div>
										</div>
										<div class="tab-content clearfix" id="tabs-2">
											<div id="recent-post-list-sidebar">

												<div class="spost clearfix">
													<div class="entry-image">
														<a href="#" class="nobg"><img class="img-circle" src="images/magazine/small/1.jpg" alt=""></a>
													</div>
													<div class="entry-c">
														<div class="entry-title">
															<h4><a href="#">Lorem ipsum dolor sit amet, consectetur</a></h4>
														</div>
														<ul class="entry-meta">
															<li>10th July 2014</li>
														</ul>
													</div>
												</div>

												<div class="spost clearfix">
													<div class="entry-image">
														<a href="#" class="nobg"><img class="img-circle" src="images/magazine/small/2.jpg" alt=""></a>
													</div>
													<div class="entry-c">
														<div class="entry-title">
															<h4><a href="#">Elit Assumenda vel amet dolorum quasi</a></h4>
														</div>
														<ul class="entry-meta">
															<li>10th July 2014</li>
														</ul>
													</div>
												</div>

												<div class="spost clearfix">
													<div class="entry-image">
														<a href="#" class="nobg"><img class="img-circle" src="images/magazine/small/3.jpg" alt=""></a>
													</div>
													<div class="entry-c">
														<div class="entry-title">
															<h4><a href="#">Debitis nihil placeat, illum est nisi</a></h4>
														</div>
														<ul class="entry-meta">
															<li>10th July 2014</li>
														</ul>
													</div>
												</div>

											</div>
										</div>
										<div class="tab-content clearfix" id="tabs-3">
											<div id="recent-post-list-sidebar">

												<div class="spost clearfix">
													<div class="entry-image">
														<a href="#" class="nobg"><img class="img-circle" src="images/icons/avatar.jpg" alt=""></a>
													</div>
													<div class="entry-c">
														<strong>John Doe:</strong> Veritatis recusandae sunt repellat distinctio...
													</div>
												</div>

												<div class="spost clearfix">
													<div class="entry-image">
														<a href="#" class="nobg"><img class="img-circle" src="images/icons/avatar.jpg" alt=""></a>
													</div>
													<div class="entry-c">
														<strong>Mary Jane:</strong> Possimus libero, earum officia architecto maiores....
													</div>
												</div>

												<div class="spost clearfix">
													<div class="entry-image">
														<a href="#" class="nobg"><img class="img-circle" src="images/icons/avatar.jpg" alt=""></a>
													</div>
													<div class="entry-c">
														<strong>Site Admin:</strong> Deleniti magni labore laboriosam odio...
													</div>
												</div>

											</div>
										</div>

									</div>

								</div>

							</div>

							<div class="widget clearfix">

								<h4>Portfolio Carousel</h4>
								<div id="oc-portfolio-sidebar" class="owl-carousel carousel-widget" data-items="1" data-margin="10" data-loop="true" data-nav="false" data-autoplay="5000">

									<div class="oc-item">
										<div class="iportfolio">
											<div class="portfolio-image">
												<a href="#">
													<img src="images/portfolio/4/3.jpg" alt="Mac Sunglasses">
												</a>
												<div class="portfolio-overlay">
													<a href="http://vimeo.com/89396394" class="center-icon" data-lightbox="iframe"><i class="icon-line-play"></i></a>
												</div>
											</div>
											<div class="portfolio-desc center nobottompadding">
												<h3><a href="portfolio-single-video.html">Mac Sunglasses</a></h3>
												<span><a href="#">Graphics</a>, <a href="#">UI Elements</a></span>
											</div>
										</div>
									</div>

									<div class="oc-item">
										<div class="iportfolio">
											<div class="portfolio-image">
												<a href="portfolio-single.html">
													<img src="images/portfolio/4/1.jpg" alt="Open Imagination">
												</a>
												<div class="portfolio-overlay">
													<a href="images/blog/full/1.jpg" class="center-icon" data-lightbox="image"><i class="icon-line-plus"></i></a>
												</div>
											</div>
											<div class="portfolio-desc center nobottompadding">
												<h3><a href="portfolio-single.html">Open Imagination</a></h3>
												<span><a href="#">Media</a>, <a href="#">Icons</a></span>
											</div>
										</div>
									</div>

								</div>


							</div>

							<div class="widget clearfix">

								<h4>Tag Cloud</h4>
								<div class="tagcloud">
									<a href="#">general</a>
									<a href="#">videos</a>
									<a href="#">music</a>
									<a href="#">media</a>
									<a href="#">photography</a>
									<a href="#">parallax</a>
									<a href="#">ecommerce</a>
									<a href="#">terms</a>
									<a href="#">coupons</a>
									<a href="#">modern</a>
								</div>

							</div>

						</div>

					</div><!-- .sidebar end -->

				</div>

			</div>

		</section><!-- #content end -->

<?php
require_once ('include/footer.html');
?>