<?php
namespace Go;
use Go\ApiController as ApiController;
use Go\Crypt as Crypt;

/***********************************
* 2016-11-17                       *
* Klevis Cipi                      * 
* cipiklevis@gmail.com             * 
*                                  * 
***********************************/

class BooksApiController extends ApiController
{

	public function index(){
		$books = $this->Model->books();

		if(empty($books)){
			$response['data'] 	= '';
			$response['error']	=1;
		}else{
			$response['data'] 	= $books;
			$response['error']	=0;
		}
		
		$this->json($response);
	}
	public function view(){
		$id = $_POST['id'];
		$book= $this->Model->book($id);

		if(empty($book)){
			$response['data'] 	= '';
			$response['error']	=1;
		}else{
			$response['data'] 	= $book;
			$response['error']	=0;
		}
		
		$this->json($response);
	}
	public function add(){
		$post 		= $_POST;
		$idgoogle 	= $post['google_id'];
		$key 		= $post['keygoogleapi'];
		$text 		= urlencode($idgoogle);
		$urls  		= 'https://www.googleapis.com/books/v1/volumes?q='.$text.'&key='.$key.'&maxResults=40';
		$url 		= file_get_contents($urls);
		$books 		= json_decode($url);
		$count 		= 0;
		if(!empty($books)){
			foreach ($books->items as $key => $book) {
					$ifauthor 	= $this->Model->ifauthor($book->volumeInfo->authors[0]);
					if(!$ifauthor){
						 $addauthor = $this->Model->addauthor($book->volumeInfo->authors[0]);
					}else{
						$author = $this->Model->author($book->volumeInfo->authors[0])[0];
					}
					
				   $author = $this->Model->author($book->volumeInfo->authors[0])[0];

			       $ifbook 	= $this->Model->ifbook($book->id);
			       if(!$ifbook){
						$post_json=[

							'google_id'		=>$book->id,
							'json_volume'	=>$book->selfLink,
							'previewlink'	=>$book->volumeInfo->previewLink,
							'title'			=>$book->volumeInfo->title,
							'author_id'		=>$author->id,
							'author_name'	=>$book->volumeInfo->authors[0],
							'publisher'		=>$book->volumeInfo->publisher,
							'publisherdate'	=>$book->volumeInfo->publishedDate,
							'description'	=>$book->volumeInfo->description,
							'pages'			=>$book->volumeInfo->pageCount,
							'rating'		=>$book->volumeInfo->averageRating,
							'language'		=>$book->volumeInfo->language,
							'categories'	=>$book->volumeInfo->categories,
							'image'			=>$book->volumeInfo->imageLinks->thumbnail,

						];
						$addbook = $this->Model->add($post_json);

						if($addbook){
							$error['error'] = 0;
							$count +=1;
						}else{
							$error['error'] += 1;
						}
			       }

			}

			if($error['error'] < 1){
				if($count > 0){

				$controller  = "Books";
				$description = "Inserted $count books";
				$this->Model->insertactions('Add',$controller,$description,Session::get('iduser'),$count);

				}

				$response['sms'] = "Congrutalations request executet and  $count books are inserted successfully!";
				$response['error'] = 0;
			}else{
				$response['sms'] = "Error, $count books are inserted, try agin?";
				$response['error'] = 0;
			}
		}else{
			$response['sms'] = "Request from google api is empty please try again!";
			$response['error'] = 0;	
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

			if($delete){
				$response['sms'] 	= 'Item deletet successfully.';
				$response['error']	=0;
				$controller  = "Books";
				$description = "Deleted 1 book";
				$this->Model->insertactions('Delete',$controller,$description,Session::get('iduser'),1);

			}else{
				$response['sms'] 	= 'Item not deletet.';
				$response['error']	= 1;
			}
		}

		
		$this->json($response);
	}
	public function deleteauthor(){

		$id =$_POST['id'];
		if(empty($id)){
			$response['sms'] 	= 'Id is impty please check again!';
			$response['error']	=1;		
		}else{
			$id = Crypt::deTokenid($id);
			$deletebooks 	= $this->Model->delete_books($id);

			$controller  = "Books";
			$description = " Inserted $count books";
			$this->Model->insertactions('Delete',$controller,$description,Session::get('iduser'),$count);

			if($deletebooks){
				$delete = $this->Model->delete($id);
				if($delete){
					$controller  = "Books";
					$description = "Deleted 1 author";
					$this->Model->insertactions('Delete',$controller,$description,Session::get('iduser'),1);

					$response['sms'] 	= 'Author deletet successfully.';
					$response['error']	=0;
				}else{
					$response['sms'] 	= 'Author not deletet.';
					$response['error']	= 1;
				}
			}else{
				$response['sms'] 	= 'Erro... Author not deletet.';
				$response['error']	= 1;
			}
		}

		
		$this->json($response);
	}


}