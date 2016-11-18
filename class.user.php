<?php
/**
 * PraviinM
 */

  class loggedInUser {
	  public $email = NULL;
	  public $hash_pw = NULL;
	  public $user_id = NULL;
		public $username = NULL;

	  //Logout
	  public function userLogOut()
	  {
		  destroySession("ThisUser");
	  }
  }

?>