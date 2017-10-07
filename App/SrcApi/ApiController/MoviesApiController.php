<?php
namespace Go;
use Go\ApiController as ApiController;
use Go\Crypt as Crypt;
use Go\Media as Media;
/***********************************
* 2016-11-15                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class MoviesApiController extends ApiController
{

	public function index(){
		$movies = $this->Model->movies();

		if(empty($movies)){
			$response['data'] 	= 'No data on database';
			$response['error']	=1;
		}else{
			$response['data'] 	= $movies;
			$response['error']	=0;
		}
		
		$this->json($response);
	}
	public function view(){
		$id = $_POST['id'];
		$movie= $this->Model->movie($id);

		if(empty($movie)){
			$response['data'] 	= '';
			$response['error']	=1;
		}else{
			$response['data'] 	= $movie;
			$response['error']	=0;
		}
		
		$this->json($response);
	}
	public function addactor(){
		$post = $_POST;
		$url = $post['urlget'].$post['idm_actor'];
		$actors = file_get_contents("$url");
		$data = json_decode($actors);
		$countactor = 0; 
		$count 		= 0; 
		if($data->status=="success"){
			if(!empty($data)){
					$string = $data->data->title;
					$title =explode(' ', $string);
					foreach ($title as $key => $value) {

						if(empty($value)){
						 unset($title[$key]);
						}
					}
					$title =implode(' ', $title);
					$ifactor=$this->Model->ifactor($data->data->id);
					if(!$ifactor){
						$add= $this->Model->addactor($data->data->id,$title,$data->data->description,$data->data->image,$data->data->occupation);
						if($add){
							$countactor +=1;
							foreach ($data->data->mediaLinks as $key => $media) {
								$addmedia = $this->Model->addactormedia($media,$data->data->id);
								if($addmedia){
									$error['mediaerror']	=0;
								}else{
								    $error['mediaerror']	=1;
								}
							}
								foreach ($data->data->filmography as $key => $movie) {
								$movieurl = explode("/", $movie->info);
								$movieid = $movieurl[4];
								$year = preg_replace("/[^0-9]/", '', $movie->year);
									if(!empty($movieid)){
										$ifmovie = $this->Model->ifmovie($movieid);
										if(!$ifmovie){
											$urlmovie = $post['urlget'].$movieid;
											$movie_on = file_get_contents("$urlmovie");
											$datamovie = json_decode($movie_on);

											$post_movies_actors = [
														'idm_id'		=>$movieid,
														'idm_actor'		=>$data->data->id,
														'info'			=>$movie->info,
														'title'			=>$movie->title,
														'year'			=>$year,
														'description'	=>$datamovie->data->description,
														'casts'			=>$datamovie->data->cast,
														'direction'		=>$datamovie->data->directors,
														'duration'		=>$datamovie->data->duration,
														'genres'		=>$datamovie->data->genres,
														'image'			=>$datamovie->data->image,
														'texts'			=>$datamovie->data->review->text,
														'rating'		=>$datamovie->data->review->rating,
														'released'		=>$datamovie->data->released,
														'writers'		=>$datamovie->data->writers

														];

											$addmovie = $this->Model->add($post_movies_actors);
											if($addmovie){
												$error['movie']	=0;
												$count += 1;
											}else{
											    $error['movie']	=1;
											}	
										}

									}
								
							}

						}
					}else{
						$response['sms'] 	= "Actor exists...";
						$response['error'] 	= 1;

					}


			}else{
				$error['get'] = 1;
				$error['smsget'] = "Empty data from url";
			}
			if($error['movie'] < 1 && $error['mediaerror'] < 1  && $error['get'] < 1){
				if($count > 0 && $countactor > 0){
					$controller  = "Movies";
					$description = "Inserted $countactor actors and $count movies";
					$this->Model->insertactions('Add',$controller,$description,Session::get('iduser'),$count);

				}
				$response['sms'] 	= 'Congratulation your request executet succesfully';
				$response['error']	=0;
			}else{
				$response['sms'] 	= "Error genereting, no actor added or actor exists";
				$response['error']	=1;
			}
		}else{
				$response['sms'] 	= "No response from idmb server, please try again";
				$response['error']	=1;	
		}



		$this->json($response);
	}
	public function addcompany(){
		$post = $_POST;
		$urlcompay = $post['urlget'].trim($post['idm_comp']);
		$company_on = file_get_contents("$urlcompay");
		$data = json_decode($company_on);
		$count = 0;
		$countcompany = 0;
		$ifcompany = $this->Model->ifcompany($data->data->id);
		if(!$ifcompany){
			$addcompay = $this->Model->addcompay($data->data->id,$data->data->title);
				if($addcompay){
			    $countcompany +=1;
				foreach ($data->data->filmography as $key => $com) {
					$movieurl = explode("/", $com->url);
					$movieid = $movieurl[4];
					$year = preg_replace("/[^0-9]/", '', $com->year);
						if(!empty($movieid)){
							$ifmovie = $this->Model->ifmovie($movieid);
							if(!$ifmovie){
								$urlmovie = $post['urlget'].$movieid;
								$movie_on = file_get_contents("$urlmovie");
								$datamovie = json_decode($movie_on);

								$post_movies_com = [
											'idm_id'		=>$movieid,
											'idm_actor'		=>$data->data->id,
											'info'			=>$com->url,
											'title'			=>$com->title,
											'year'			=>$year,
											'description'	=>$datamovie->data->description,
											'casts'			=>$datamovie->data->cast,
											'direction'		=>$datamovie->data->directors,
											'duration'		=>$datamovie->data->duration,
											'genres'		=>$datamovie->data->genres,
											'image'			=>$datamovie->data->image,
											'texts'			=>$datamovie->data->review->text,
											'rating'		=>$datamovie->data->review->rating,
											'released'		=>$datamovie->data->released,
											'writers'		=>$datamovie->data->writers

											];

								$addmovie = $this->Model->add($post_movies_com);
								if($addmovie){
									$error['movie']	=0;
									$count +=1;
								}else{
								    $error['movie']	=1;
								}	
							}

						}
					
				}
			}
		 if($error['movie'] < 1){
		 	$response['sms'] 	= 'Congratulation your request executet succesfully';
			$response['error']	=0;	
			if($count > 0 && $countcompany > 0){
				$controller  = "Movies";
				$description = " Inserted $countcompany company and $count movies";
				$this->Model->insertactions('Add',$controller,$description,Session::get('iduser'),$count);
			}
		 }else{
		 	$response['sms'] 	= "Error genereting, no actor added or actor exists";
			$response['error']	=1;	
		 }
		}else{
			$response['sms'] 	= "Company exists ( $data->data->title ), Try another company";
			$response['error']	=1;					
		}

		$this->json($response);
	}
	public function addmovie(){
		$post = $_POST;
		$url = $post['urlget'].trim($post['idm_movie']);
		$movie_on = file_get_contents("$url");
		$movie = json_decode($movie_on);
		$count = 0;
		if($movie->status=='success' && $movie->code=="200"){
			if(!empty($movie->data->id)){
				$ifmovie = $this->Model->ifmovie($movie->data->id);

				if(!$ifmovie){
					
					foreach ($movie->data->cast as $key => $cast) {

							$actor=$this->Model->selectactor($cast);
							if(!empty( $actor->idm_id ) ){
								$actor_id=$actor->idm_id;
							}else{
								$actor_id = "";
							}
					}
					if($actor_id){
						$actor_id = "";
					}else{
						$actor_id = $actor_id;
					}

					if( empty( $movie->data->year ) ){
						$movie->data->year = substr($movie->data->released,0,4);
					}
					if( empty( $movie->data->title ) ){
						$movie->data->title = substr($movie->data->description,0,30);
					}
					if( empty( $movie->data->review ) ){
						$rating = "";
						$text 	= "";
					}else{
						$rating=$movie->data->review->rating;
						$text = $movie->data->review->text;
					}
					$forlink = $movie->data->id;
					$info = "http://www.imdb.com/title/".$forlink."/";
					$post_movie = [
								'idm_id'		=>$movie->data->id,
								'idm_actor'		=>$actor_id,
								'info'			=>$info,
								'title'			=>$movie->data->title,
								'year'			=>$movie->data->year,
								'description'	=>$movie->data->description,
								'casts'			=>$movie->data->cast,
								'direction'		=>$movie->data->directors,
								'duration'		=>$movie->data->duration,
								'genres'		=>$movie->data->genres,
								'image'			=>$movie->data->image,
								'texts'			=>$text,
								'rating'		=>$rating,
								'released'		=>$movie->data->released,
								'writers'		=>$movie->data->writers

								];

					$addmovie = $this->Model->add($post_movie);
					if($addmovie){
						$error['movie']	=0;
						$count +=1;
					}else{
					    $error['movie']	=1;
					}

					if($error['movie'] < 1){
					 	$response['sms'] 	= 'Congratulation your request executet succesfully';
					 	$response['data'] 	= $actor;
						$response['error']	=0;
						if($count > 0){
							$controller  = "Movies";
							$description = "Inserted  $count movies";
							$this->Model->insertactions('Add',$controller,$description,Session::get('iduser'),$count);
						}	
					 }else{
					 	$response['sms'] 	= "Error genereting, no actor added or actor exists";
						$response['error']	=1;	
					 }	
				}else{

				 	$response['sms'] 	= "Movie exists please try another id";
					$response['error']	=1;						
				}

			}else{
				$response['sms'] 	= "Response data are empty please try another id movie";
				$response['error']	=1;					
			}
		}else{
				$response['sms'] 	= "No response from idmb api server, please try again";
				$response['data'] 	= $movie;
				$response['error']	=1;				
		}

		$this->json($response);
	}
/****************************MOVIE CAST*********************************/
public function addmoviecast(){
		$post = $_POST;
		$url = $post['urlget'].trim($post['idm_castmovie']);
		$movie_on = file_get_contents("$url");
		$movie = json_decode($movie_on);
		$count 		= 0;
		$countactor = 0;
		if($movie->status=='success' && $movie->code=="200"){
			if(!empty($movie->data->id)){
				foreach ($movie->data->cast as $key => $cast) {
				//********************************ACTORS***************************************************/
				$cast = str_replace(' ', '', $cast);
				$urlactor ="http://imdb.wemakesites.net/api/search?q=".$cast."";
						$actor = file_get_contents("$urlactor");
						$datas = json_decode($actor);
						if($datas->status=="success"){
							$urlactors ="http://imdb.wemakesites.net/api/".$datas->data->results->names[0]->id."";
							
							$actors = file_get_contents("$urlactors");
							$data = json_decode($actors);
								if($data->status=="success"){
									if(!empty($data)){
											$string = $data->data->title;
											$title =explode(' ', $string);
											foreach ($title as $key => $value) {
												if(empty($value)){
												 unset($title[$key]);
												}
											}
											$title =implode(' ', $title);
											$ifactor=$this->Model->ifactor($data->data->id);
											if(!$ifactor){
												$add= $this->Model->addactor($data->data->id,$title,$data->data->description,$data->data->image,$data->data->occupation);
												if($add){
													$countactor +=1;
													foreach ($data->data->mediaLinks as $key => $media) {
														$addmedia = $this->Model->addactormedia($media,$data->data->id);
														if($addmedia){
															$error['mediaerror']	=0;
														}else{
														    $error['mediaerror']	=1;
														}
													}
														foreach ($data->data->filmography as $key => $movie) {
														$movieurl = explode("/", $movie->info);
														$movieid = $movieurl[4];
														$year = preg_replace("/[^0-9]/", '', $movie->year);
															if(!empty($movieid)){
																$ifmovie = $this->Model->ifmovie($movieid);
																if(!$ifmovie){
																	$urlmovie = $post['urlget'].$movieid;
																	$movie_on = file_get_contents("$urlmovie");
																	$datamovie = json_decode($movie_on);

																	$post_movies_actors = [
																				'idm_id'		=>$movieid,
																				'idm_actor'		=>$data->data->id,
																				'info'			=>$movie->info,
																				'title'			=>$movie->title,
																				'year'			=>$year,
																				'description'	=>$datamovie->data->description,
																				'casts'			=>$datamovie->data->cast,
																				'direction'		=>$datamovie->data->directors,
																				'duration'		=>$datamovie->data->duration,
																				'genres'		=>$datamovie->data->genres,
																				'image'			=>$datamovie->data->image,
																				'texts'			=>$datamovie->data->review->text,
																				'rating'		=>$datamovie->data->review->rating,
																				'released'		=>$datamovie->data->released,
																				'writers'		=>$datamovie->data->writers

																				];

																	$addmovie = $this->Model->add($post_movies_actors);
																	if($addmovie){
																		$error['movicast']	=0;
																		$count +=1;
																	}else{
																	    $error['movicast']	=1;
																	}	
																}

															}
														
													}

												}
											}

									}
								}
						}

				/***********************************close actors*************************************************/

			}
				$ifmovie = $this->Model->ifmovie($movie->data->id);

				if(!$ifmovie){
					
					foreach ($movie->data->cast as $key => $cast) {

							$actor=$this->Model->selectactor($cast);
							if(!empty( $actor->idm_id ) ){
								$actor_id=$actor->idm_id;
							}else{
								$actor_id = "";
							}
					}
					if($actor_id){
						$actor_id = "";
					}else{
						$actor_id = $actor_id;
					}

					if( empty( $movie->data->year ) ){
						$movie->data->year = substr($movie->data->released,0,4);
					}
					if( empty( $movie->data->title ) ){
						$movie->data->title = substr($movie->data->description,0,30);
					}
					if( empty( $movie->data->review ) ){
						$rating = "";
						$text 	= "";
					}else{
						$rating=$movie->data->review->rating;
						$text = $movie->data->review->text;
					}
					$forlink = $movie->data->id;
					$info = "http://www.imdb.com/title/".$forlink."/";
					$post_movie = [
								'idm_id'		=>$movie->data->id,
								'idm_actor'		=>$actor_id,
								'info'			=>$info,
								'title'			=>$movie->data->title,
								'year'			=>$movie->data->year,
								'description'	=>$movie->data->description,
								'casts'			=>$movie->data->cast,
								'direction'		=>$movie->data->directors,
								'duration'		=>$movie->data->duration,
								'genres'		=>$movie->data->genres,
								'image'			=>$movie->data->image,
								'texts'			=>$text,
								'rating'		=>$rating,
								'released'		=>$movie->data->released,
								'writers'		=>$movie->data->writers

								];

					$addmovie = $this->Model->add($post_movie);
					if($addmovie){
						$error['movie']	=0;
						$count +=1;
					}else{
					    $error['movie']	=1;
					}

				}
				if($error['movicast'] < 1){
				 	$response['sms'] 	= 'Congratulation your request executet succesfully';
				 	$response['data'] 	= $actor;
					$response['error']	=0;	
					if($count > 0 && $countactor > 0){
						$controller  = "Movies";
						$description = "Inserted $countactor actors and $count movies";
						$this->Model->insertactions('Add',$controller,$description,Session::get('iduser'),$count);
					}
				 }else{
				 	$response['sms'] 	= "Error genereting, no actor added or actor exists";
					$response['error']	=1;	
				 }	

			}else{
				$response['sms'] 	= "Response data are empty please try another id movie";
				$response['error']	=1;					
			}
		}else{
				$response['sms'] 	= "No response from idmb api server, please try again";
				$response['data'] 	= $movie;
				$response['error']	=1;				
		}

		$this->json($response);
	}
	public function delete(){

		$id =$_POST['id'];
		if(empty($id)){
			$response['sms'] 	= 'Id is impty please check again!';
			$response['error']	=1;		
		}else{
			$id = Crypt::deTokenid($id);
			$delete = $this->Model->delete($id);

			$controller  = "Movies";
			$description = "Deleted 1 movie";
			$this->Model->insertactions('Delete',$controller,$description,Session::get('iduser'),1);
		
			if($delete){
				$response['sms'] 	= 'Movie deletet successfully.';
				$response['error']	=0;
			}else{
				$response['sms'] 	= 'Movie not deletet.';
				$response['error']	= 1;
			}
		}
		
		$this->json($response);
	}

    public function deleteactor(){

		$id =$_POST['id'];
		if(empty($id)){
			$response['sms'] 	= 'Id is impty please check again!';
			$response['error']	=1;		
		}else{
			$id = Crypt::deTokenid($id);
			$deletemovies = $this->Model->delete_movies($id);
			if($deletemovies){
				$delete = $this->Model->delete_actor($id);
				if($delete){
					$response['sms'] 	= 'Actor deletet successfully.';
					$response['error']	=1;

					$controller  = "Movies";
					$description = "Deleted 1 actors and some movies";
					$this->Model->insertactions('Delete',$controller,$description,Session::get('iduser'),$count);
						
				}else{
					$response['sms'] 	= 'Actor not deletet.';
					$response['error']	= 0;
				}
			}else{
					$response['sms'] 	= 'Movies no deletet....';
					$response['error']	= 1;				
			}



		}

		
		$this->json($response);
	}
	public function addtrailer(){
		$val = $_POST['value'];
		$id  = $_POST['id'];
		if(!empty($val) && !empty($id)){
			$ifexist=$this->Model->iftrailerexist($id);
			if($ifexist){
				$update =$this->Model->updatetrailer($id,$val);
				if($update){
					$response['sms'] 	= 'Trailer update successfully';
					$response['error']	= 0;	
				}else{
					$response['sms'] 	= 'Trailer not update';
					$response['error']	= 1;	
				}
			}else{
				$insert =$this->Model->inserttrailer($id,$val);
				if($insert){
					$response['sms'] 	= 'Trailer inserted successfully';
					$response['error']	= 0;	
				}else{
					$response['sms'] 	= 'Trailer not inserted';
					$response['error']	= 1;	
				}
			}
		}else{
					$response['sms'] 	= 'Empty post ,please check again';
					$response['error']	= 1;	
		}
		$this->json($response);
	}

	public function addonsite(){
		$val = $_POST['value'];
		$id  = $_POST['id'];
		if(!empty($val) && !empty($id)){

				$update =$this->Model->addonsite($id,$val);
				if($update){
					$response['sms'] 	= 'Movie updated successfully';
					$response['error']	= 0;	
				}else{
					$response['sms'] 	= 'Movie not update';
					$response['error']	= 1;	
				}
		}else{
					$response['sms'] 	= 'Empty post ,please check again';
					$response['error']	= 1;	
		}
		$this->json($response);
	}

	public function addonheadersite(){
		$val = $_POST['value'];
		$id  = $_POST['id'];
		if(!empty($val) && !empty($id)){

				$update =$this->Model->addonheadersite($id,$val);
				if($update){
					$response['sms'] 	= 'Movie updated successfully';
					$response['error']	= 0;	
				}else{
					$response['sms'] 	= 'Movie not update';
					$response['error']	= 1;	
				}
		}else{
					$response['sms'] 	= 'Empty post ,please check again';
					$response['error']	= 1;	
		}
		$this->json($response);
	}

}