<?php 
  class Customers{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }
    
    
    public function addToCart($book_id, $customer_id, $quantity) {
      try {
          $this->db->query('INSERT INTO cart (book_id, customer_id, quantity) VALUES (:book_id, :customer_id, :quantity)');
          $this->db->bind(':book_id', $book_id);
          $this->db->bind(':customer_id', $customer_id);
          $this->db->bind(':quantity', $quantity);
  
          return $this->db->execute();
      } catch (\Exception $e) {
          // Handle the exception (e.g., log it, display an error message)
          echo 'Error: ' . $e->getMessage();
          return false; 
      }
    }
    public function updateReview($review_id,$rating,$description) {
      $this->db->query('UPDATE content_review SET review = :review, rate = :rating WHERE review_id = :review_id');
      $this->db->bind(':review', $description);
      $this->db->bind(':rating', $rating);
      $this->db->bind(':review_id', $review_id);

      // Execute
      if ($this->db->execute()) {
          return true;
      } else {
          return false;
      }
    }

    public function deleteReview($review_id){
      $this->db->query('DELETE FROM content_review WHERE review_id = :review_id');
      $this->db->bind(':review_id', $review_id);
      $this->db->execute();
      if ($this->db->rowCount() > 0) {
          return true;
      } else {
          return false;
      }
    }
    public function deleteReviewBook($review_id){
      $this->db->query('DELETE FROM reviews WHERE review_id = :review_id');
      $this->db->bind(':review_id', $review_id);
      $this->db->execute();
      if ($this->db->rowCount() > 0) {
          return true;
      } else {
          return false;
      }
    }
    public function findCartById($customer_id) {
      $this->db->query('SELECT c.*, b.book_name,b.discounts, b.price, b.img1, b.type FROM cart c
                        JOIN books b ON c.book_id = b.book_id
                        WHERE c.customer_id = :customer_id');
      $this->db->bind(':customer_id', $customer_id);

      return $this->db->resultSet();
    }
    public function findCustomerById($user_id){
        $this->db->query('SELECT * from customers WHERE user_id=:user_id');
        $this->db->bind(':user_id',$user_id);
       

        return $this->db->resultSet();
    }

    public function findCharityEventById($charity_event_id){
      $this->db->query('SELECT * from charity_event WHERE charity_event_id=:charity_event_id');
      $this->db->bind(':charity_event_id',$charity_event_id);
     

      return $this->db->resultSet();
  }
  
    public function findUsedBookByCusId($customer_id){
      $this->db->query('SELECT * from books WHERE customer_id=:customer_id AND type="used"');
      $this->db->bind(':customer_id',$customer_id);
     

      return $this->db->resultSet();
    }

    public function findEventByUserId($user_id) {
      $this->db->query('SELECT * FROM events WHERE user_id = :user_id AND status="Approved"');
      $this->db->bind(':user_id', $user_id);
  
      return $this->db->resultSet();
    }

    public function findFavoriteByCustomerId($customer_id) {
      $this->db->query('SELECT * FROM favorite WHERE customer_id = :customer_id');
      $this->db->bind(':customer_id', $customer_id);
  
      return $this->db->resultSet();
    }

    public function findNewBooksFavoriteByCustomerId($customer_id) {
      $this->db->query('SELECT item_id,fav_id FROM favorite WHERE customer_id = :customer_id AND category="New Book"');
      $this->db->bind(':customer_id', $customer_id);
  
      return $this->db->resultSet();
    }

    public function findUsedBooksFavoriteByCustomerId($customer_id) {
      $this->db->query('SELECT item_id,fav_id FROM favorite WHERE customer_id = :customer_id AND category="Used Book"');
      $this->db->bind(':customer_id', $customer_id);
  
      return $this->db->resultSet();
    }

    public function findExchangeBooksFavoriteByCustomerId($customer_id) {
      $this->db->query('SELECT item_id,fav_id FROM favorite WHERE customer_id = :customer_id AND category="Exchange Book"');
      $this->db->bind(':customer_id', $customer_id);
  
      return $this->db->resultSet();
    }

    public function findContentFavoriteByCustomerId($customer_id) {
      $this->db->query('SELECT item_id,fav_id FROM favorite WHERE customer_id = :customer_id AND category="Content"');
      $this->db->bind(':customer_id', $customer_id);
  
      return $this->db->resultSet();
    }

    public function findEventByNotUserId($user_id) {
      $this->db->query('SELECT * FROM events WHERE user_id != :user_id AND status="Approved"');
      $this->db->bind(':user_id', $user_id);
  
      return $this->db->resultSet();
    }

    public function findEventById($id){
      $this->db->query('SELECT * from events WHERE id=:id');
      $this->db->bind(':id',$id);
      return $this->db->resultSet();
      // $row = $this->db->single();
      // return $row;
    }

    public function findFavoriteById($fav_id){
      $this->db->query('SELECT * from favorite WHERE fav_id=:fav_id');
      $this->db->bind(':fav_id',$fav_id);
      return $this->db->resultSet();
      // $row = $this->db->single();
      // return $row;
    }

    public function findsaveevent($user_id){
      $this->db->query('SELECT * from saveevent WHERE user_id=:user_id');
      $this->db->bind(':user_id',$user_id);
      return $this->db->resultSet();
    }

    public function checkEventInCalendar($user_id, $eventId){
      $this->db->query('SELECT * FROM saveevent WHERE user_id = :user_id AND event_id = :eventId');
      $this->db->bind(':user_id', $user_id);
      $this->db->bind(':eventId', $eventId);
      $this->db->execute();
      return $this->db->rowCount() > 0;
  }

  public function findNoOfSaveEvent($user_id) {
      $this->db->query('SELECT COUNT(*) AS count FROM saveevent WHERE user_id=:user_id');
      $this->db->bind(':user_id',$user_id);
      $result = $this->db->single();
      return $result->count;
  }
  

    public function findUsedBookByNotCusId($customer_id) {
      $this->db->query('SELECT * FROM books WHERE customer_id != :customer_id AND type="used" AND status="approval"');
      $this->db->bind(':customer_id', $customer_id);
  
      return $this->db->resultSet();
    }
  

    public function findExchangedBookByCusId($customer_id){
      $this->db->query('SELECT * from books WHERE customer_id=:customer_id AND type="exchanged"');
      $this->db->bind(':customer_id',$customer_id);
     

      return $this->db->resultSet();
    }

    public function findExchangedBookByNotCusId($customer_id){

      $this->db->query('SELECT b.* , c.user_id AS customer_user_id from books b JOIN customers c ON b.customer_id=c.customer_id  WHERE b.customer_id!=:customer_id AND b.type="exchanged" AND b.status="approval"');

      $this->db->bind(':customer_id',$customer_id);

      return $this->db->resultSet();
    }
    // public function getUsedBookById($book_id){
    //   $this->db->query('SELECT * from books WHERE book_id=:book_id ');
    //   $this->db->bind(':book_id',$book_id);
    //   return $this->db->resultSet();
    //   // $row = $this->db->single();
    //   // return $row;
    // }

    

    // public function findExchangeBookById($book_id) {
    //   $this->db->query('SELECT * from books WHERE book_id=:book_id');
    //   $this->db->bind(':book_id',$book_id);
    //   $row = $this->db->single();
    //   return $row;
    // }




    public function addComment($data) {
      // Assuming $this->db is an instance of your database class
      $this->db->query('INSERT INTO comments (name, comment, parent_comment) VALUES (:name, :comment, :parent_comment)');
      $this->db->bind(':name', $data['name']);
      $this->db->bind(':comment', $data['comment']);
      $this->db->bind(':parent_comment', $data['parentComment']);
      return $this->db->execute();
    }

    public function getComments() {
      $this->db->query('SELECT * FROM comments ORDER BY timestamp DESC');
      return $this->db->resultSet();
    }

    public function AddExchangeBook($data){
      $this->db->query('INSERT INTO books (book_name, ISBN_no, author, category, weight, descript, booksIWant, img1, img2, img3, `condition`, published_year, type, town, district, postal_code, customer_id, status) 
                                  VALUES(:book_name, :ISBN_no, :author, :category, :weight, :descript, :booksIWant, :img1, :img2, :img3, :condition, :published_year, :type, :town, :district, :postal_code, :customer_id, :status)');
      
      $this->db->bind(':book_name',$data['book_name']);
      $this->db->bind(':ISBN_no',$data['ISBN_no']);
      $this->db->bind(':author',$data['author']);
      
      $this->db->bind(':category',$data['category']);
      $this->db->bind(':weight',$data['weight']);
      $this->db->bind(':descript',$data['descript']);
      $this->db->bind(':booksIWant',$data['booksIWant']);
      $this->db->bind(':img1',$data['img1']);
      $this->db->bind(':img2',$data['img2']);
      $this->db->bind(':img3',$data['img3']);
      $this->db->bind(':condition',$data['condition']);
      $this->db->bind(':published_year',$data['published_year']);
      $this->db->bind(':type',$data['type']);
      $this->db->bind(':town',$data['town']);
      $this->db->bind(':district',$data['district']);
      $this->db->bind(':postal_code',$data['postal_code']);
      $this->db->bind(':customer_id', $data['customer_id']);
      $this->db->bind(':status', $data['status']);
      // execute
      if($this->db->execute()){
          return true;
      }else{
          return false;
      }
    }

    public function AddEvent($data) {
      $this->db->query('INSERT INTO events (title, description, location, category_name, start_date, end_date, start_time, end_time, poster, img1, img2, img3, img4, img5, user_id, status) 
                                  VALUES(:title, :description, :location, :category_name, :start_date, :end_date, :start_time, :end_time, :poster, :img1, :img2, :img3, :img4, :img5, :user_id, :status)');
      
      $this->db->bind(':title',$data['title']);
      $this->db->bind(':description',$data['description']);
      $this->db->bind(':location',$data['location']);
      $this->db->bind(':category_name',$data['category_name']);
      $this->db->bind(':start_date',$data['start_date']);
      $this->db->bind(':end_date',$data['end_date']);
      $this->db->bind(':start_time',$data['start_time']);
      $this->db->bind(':end_time',$data['end_time']);
      $this->db->bind(':poster',$data['poster']);
      $this->db->bind(':img1',$data['img1']);
      $this->db->bind(':img2',$data['img2']);
      $this->db->bind(':img3',$data['img3']);
      $this->db->bind(':img4',$data['img4']);
      $this->db->bind(':img5',$data['img5']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':status', $data['status']);
      // execute
      if($this->db->execute()){
          return true;
      }else{
          return false;
      } 
    }

    public function AddEventToCalender($data) {
      $this->db->query('INSERT INTO saveevent (title, start_date, end_date, start_time, end_time, user_id, event_id)
                                        VALUES(:title, :start_date, :end_date, :start_time, :end_time, :user_id, :event_id)');

      $this->db->bind(':title',$data['title']);
      $this->db->bind(':start_date',$data['start_date']);
      $this->db->bind(':end_date',$data['end_date']);
      $this->db->bind(':start_time',$data['start_time']);
      $this->db->bind(':end_time',$data['end_time']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':event_id', $data['event_id']);
      // execute
      if($this->db->execute()){
          return true;
      }else{
          return false;
      }
    }
    public function AddUsedBook($data){
      $this->db->query('INSERT INTO books (book_name, ISBN_no, author, price, category, weight, descript, img1, img2, img3, `condition`, published_year, price_type, type, quantity, account_name, account_no, bank_name, branch_name, town, district, postal_code, customer_id, status) 
                                  VALUES(:book_name, :ISBN_no, :author, :price, :category, :weight, :descript, :img1, :img2, :img3, :condition, :published_year, :price_type, :type, :quantity, :account_name, :account_no, :bank_name, :branch_name, :town, :district, :postal_code, :customer_id, :status)');
      $this->db->bind(':book_name',$data['book_name']);
      $this->db->bind(':ISBN_no',$data['ISBN_no']);
      // $this->db->bind(':ISSN_no',$data['ISSN_no']);
      // $this->db->bind(':ISMN_no',$data['ISMN_no']);
      $this->db->bind(':author',$data['author']);
      $this->db->bind(':price',$data['price']);
      $this->db->bind(':category',$data['category']);
      $this->db->bind(':weight',$data['weight']);
      $this->db->bind(':descript',$data['descript']);
      $this->db->bind(':img1',$data['img1']);
      $this->db->bind(':img2',$data['img2']);
      $this->db->bind(':img3',$data['img3']);
      $this->db->bind(':condition',$data['condition']);
      $this->db->bind(':published_year',$data['published_year']);
      $this->db->bind(':price_type',$data['price_type']);
      $this->db->bind(':type',$data['type']);
      $this->db->bind(':quantity',1); 
      $this->db->bind(':account_name',$data['account_name']);
      $this->db->bind(':account_no',$data['account_no']);
      $this->db->bind(':bank_name',$data['bank_name']);
      $this->db->bind(':branch_name',$data['branch_name']);
      $this->db->bind(':town',$data['town']);
      $this->db->bind(':district',$data['district']);
      $this->db->bind(':postal_code',$data['postal_code']);
      $this->db->bind(':customer_id', $data['customer_id']);
      $this->db->bind(':status', $data['status']);
      // execute
      if($this->db->execute()){
          return true;
      }else{
          return false;
      }        
    }

    public function updateusedbook($data) {
      $this->db->query('UPDATE books 
                SET book_name = :book_name, 
                ISBN_no = :ISBN_no, 
                author = :author,  
                price = :price, 
                category = :category,
                weight = :weight,
                descript = :descript,
                img1 = :img1,
                img2 = :img2,
                img3 = :img3,
                `condition` = :condition, 
                published_year = :published_year,  
                price_type = :price_type, 
                type = :type,
                account_name = :account_name,
                account_no = :account_no,
                bank_name = :bank_name,
                branch_name = :branch_name,
                town = :town, 
                district = :district,  
                postal_code = :postal_code, 
                customer_id = :customer_id,
                status = :status
                WHERE book_id = :book_id');

      // Bind values
      $this->db->bind(':book_id',$data['book_id']);
      $this->db->bind(':book_name',$data['book_name']);
      $this->db->bind(':ISBN_no',$data['ISBN_no']);
      // $this->db->bind(':ISSN_no',$data['ISSN_no']);
      // $this->db->bind(':ISMN_no',$data['ISMN_no']);
      $this->db->bind(':author',$data['author']);
      $this->db->bind(':price',$data['price']);
      $this->db->bind(':category',$data['category']);
      $this->db->bind(':weight',$data['weight']);
      $this->db->bind(':descript',$data['descript']);
      $this->db->bind(':img1',$data['img1']);
      $this->db->bind(':img2',$data['img2']);
      $this->db->bind(':img3',$data['img3']);
      $this->db->bind(':condition',$data['condition']);
      $this->db->bind(':published_year',$data['published_year']);
      $this->db->bind(':price_type',$data['price_type']);
      $this->db->bind(':type',$data['type']);
      $this->db->bind(':account_name',$data['account_name']);
      $this->db->bind(':account_no',$data['account_no']);
      $this->db->bind(':bank_name',$data['bank_name']);
      $this->db->bind(':branch_name',$data['branch_name']);
      $this->db->bind(':town',$data['town']);
      $this->db->bind(':district',$data['district']);
      $this->db->bind(':postal_code',$data['postal_code']);
      $this->db->bind(':customer_id', $data['customer_id']);
      $this->db->bind(':status', $data['status']);

      // Execute
      if ($this->db->execute()) {
          return true;
      } else {
          return false;
      }
    }

    public function updateexchangebook($data){
      $this->db->query('UPDATE books 
                SET book_name = :book_name, 
                ISBN_no = :ISBN_no, 
                author = :author, 
                category = :category,
                weight = :weight,
                descript = :descript,
                booksIWant = :booksIWant,
                img1 = :img1,
                img2 = :img2,
                img3 = :img3,
                `condition` = :condition, 
                published_year = :published_year,  
                type = :type,
                town = :town, 
                district = :district,  
                postal_code = :postal_code, 
                customer_id = :customer_id,
                status = :status
                WHERE book_id = :book_id');

      // Bind values
      $this->db->bind(':book_id',$data['book_id']);
      $this->db->bind(':book_name',$data['book_name']);
      $this->db->bind(':ISBN_no',$data['ISBN_no']);
      $this->db->bind(':author',$data['author']);
      $this->db->bind(':category',$data['category']);
      $this->db->bind(':weight',$data['weight']);
      $this->db->bind(':descript',$data['descript']);
      $this->db->bind(':booksIWant',$data['booksIWant']);
      $this->db->bind(':img1',$data['img1']);
      $this->db->bind(':img2',$data['img2']);
      $this->db->bind(':img3',$data['img3']);
      $this->db->bind(':condition',$data['condition']);
      $this->db->bind(':published_year',$data['published_year']);
      $this->db->bind(':type',$data['type']);
      $this->db->bind(':town',$data['town']);
      $this->db->bind(':district',$data['district']);
      $this->db->bind(':postal_code',$data['postal_code']);
      $this->db->bind(':customer_id', $data['customer_id']);
      $this->db->bind(':status', $data['status']);

      // Execute
      if ($this->db->execute()) {
          return true;
      } else {
          return false;
      }
    }

    public function UpdateEvent($data){
      $this->db->query('UPDATE events 
                SET title = :title, 
                description = :description, 
                location = :location, 
                category_name = :category_name,
                start_date = :start_date,
                end_date = :end_date,
                start_time = :start_time,
                end_time = :end_time,
                poster = :poster,
                img1 = :img1,
                img2 = :img2,
                img3 = :img3,
                img4 = :img4,
                img5 = :img5,
                user_id = :user_id,
                status = :status
                WHERE id = :id');

      // Bind values
      $this->db->bind(':title',$data['title']);
      $this->db->bind(':description',$data['description']);
      $this->db->bind(':location',$data['location']);
      $this->db->bind(':category_name',$data['category_name']);
      $this->db->bind(':start_date',$data['start_date']);
      $this->db->bind(':end_date',$data['end_date']);
      $this->db->bind(':start_time',$data['start_time']);
      $this->db->bind(':end_time',$data['end_time']);
      $this->db->bind(':poster',$data['poster']);
      $this->db->bind(':img1',$data['img1']);
      $this->db->bind(':img2',$data['img2']);
      $this->db->bind(':img3',$data['img3']);
      $this->db->bind(':img4',$data['img4']);
      $this->db->bind(':img5',$data['img5']);
      $this->db->bind(':user_id', $data['user_id']);
      $this->db->bind(':id', $data['id']);
      $this->db->bind(':status', $data['status']);

      // Execute
      if ($this->db->execute()) {
          return true;
      } else {
          return false;
      }
    }

    public function updateContent($data){
      $this->db->query('UPDATE content 
                SET topic = :topic, 
                text = :text, 
                img = :img, 
                doc = :doc,
                customer_id = :customer_id,
                status = :status
                WHERE content_id = :content_id');
      $this->db->bind(':customer_id',$data['customer_id']);
      $this->db->bind(':topic',$data['topic']);
      $this->db->bind(':text',$data['text']);
      $this->db->bind(':img',$data['picture']);
      $this->db->bind(':doc',$data['pdf']);
      $this->db->bind(':status',$data['status']);
      $this->db->bind(':content_id',$data['content_id']);
      // execute
      if($this->db->execute()){
          return true;
      }else{
          return false;
      }        
    }

    public function deleteusedbook($book_id) {
      $this->db->query('DELETE FROM books WHERE book_id = :book_id');
      // Bind values
      $this->db->bind(':book_id', $book_id);

      // Execute after binding
      $this->db->execute();

      // Check for row count affected
      if ($this->db->rowCount() > 0) {
          return true;
      } else {
          return false;
      }
    }

    public function deleteEvent($id) {
      $this->db->query('DELETE FROM events WHERE id = :id');

      $this->db->bind(':id', $id);

      // Execute after binding
      $this->db->execute();

      // Check for row count affected
      if ($this->db->rowCount() > 0) {
          return true;
      } else {
          return false;
      }
    }

    public function deleteContent($content_id) {
      $this->db->query('DELETE FROM content WHERE content_id = :content_id');

      $this->db->bind(':content_id', $content_id);

      // Execute after binding
      $this->db->execute();

      // Check for row count affected
      if ($this->db->rowCount() > 0) {
          return true;
      } else {
          return false;
      }
    }

    public function deleteFavorite($fav_id) {
      $this->db->query('DELETE FROM favorite WHERE fav_id = :fav_id');

      $this->db->bind(':fav_id', $fav_id);

      // Execute after binding
      $this->db->execute();

      // Check for row count affected
      if ($this->db->rowCount() > 0) {
          return true;
      } else {
          return false;
      }
    }

    public function RemoveEventFromCalender($data){
      $this->db->query('DELETE FROM saveevent WHERE user_id = :user_id AND event_id = :event_id');
  
      $this->db->bind(':event_id', $data['event_id']);
      $this->db->bind(':user_id', $data['user_id']);
  
      // Execute after binding
      $this->db->execute();
  
      // Check for row count affected
      if ($this->db->rowCount() > 0) {
          return true;
      } else {
          return false;
      }
  }
  


  public function addOrder($data){
    $this->db->query('INSERT INTO orders (customer_id, c_postal_name, c_street_name, c_town, c_district, c_postal_code,contact_no,total_price,total_weight,total_delivery) VALUES( :customer_id,  :c_postal_name, :c_street_name, :c_town, :c_district, :c_postal_code, :contact_no, :total_price, :total_weight, :total_delivery)');
    
    
    $this->db->bind(':customer_id',$data['customer_id']);
    $this->db->bind(':c_postal_name',$data['postal_name']);
    $this->db->bind(':c_street_name',$data['street_name']);
    $this->db->bind(':c_town',$data['town']);
    $this->db->bind(':c_district',$data['district']);
    $this->db->bind(':c_postal_code',$data['postal_code']);
    $this->db->bind(':contact_no', $data['contact_no']);
    $this->db->bind(':total_price', $data['total_cost']);
    $this->db->bind(':total_weight', $data['total_weight']);
    $this->db->bind(':total_delivery',$data['totalDelivery']);
    // $this->db->bind(':quantity',$data['quantity']);
    // $this->db->bind(':total_delivery',$data['total_delivery']);
    
   
   
   
    // execute
    if($this->db->execute()){
        return true;
    }else{
        return false;
    }        
  }
  
  public function addCont($data){
    $this->db->query('INSERT INTO content (customer_id,topic,text,img, doc) VALUES( :customer_id, :topic, :text, :img,  :doc)'); 
    $this->db->bind(':customer_id',$data['customer_id']);
    $this->db->bind(':topic',$data['topic']);
    $this->db->bind(':text',$data['text']);
    $this->db->bind(':img',$data['picture']);
    $this->db->bind(':doc',$data['pdf']);
    // execute
    if($this->db->execute()){
        return true;
    }else{
        return false;
    }        
  }
  
  public function findContentById($content_id){
    $this->db->query('SELECT c.*, cus.* FROM content c JOIN customers cus ON c.customer_id = cus.customer_id WHERE c.content_id = :content_id AND c.status="approval"');
    $this->db->bind(':content_id', $content_id);
    return $this->db->resultSet();
}

public function findContentByContentId($content_id){
  $this->db->query('SELECT * FROM content WHERE content_id = :content_id AND status="approval"');
  $this->db->bind(':content_id', $content_id);
  return $this->db->resultSet();
}


  public function getLastInsertedOrderId() {
    $this->db->query('SELECT LAST_INSERT_ID() as order_id');
    $row = $this->db->single();
    return $row->order_id;
}
public function editOrder($data)
{
    $this->db->query('UPDATE orders
              SET recipt = :recipt,
              payment_type = :payment_type ,
              tracking_no = :tracking_no
              WHERE order_id = :order_id');

    // Bind values
    $this->db->bind(':order_id', $data['order_id']);
    $this->db->bind(':recipt', $data['recipt']);
    $this->db->bind(':payment_type', $data['formType']);  // Use 'formType' instead of 'payment_type'
    $this->db->bind(':tracking_no', $data['trackingNumber']);
    // Execute
    if ($this->db->execute()) {
        return true;
    } else {
        return false;
    }
}
public function editOrderCOD($data)
{
    $this->db->query('UPDATE orders o
                      JOIN order_details od ON o.order_id = od.order_id
                      SET 
                          o.payment_type = :payment_type,
                          o.tracking_no = :tracking_no,
                        
                          od.status = :status_order_details
                      WHERE o.order_id = :order_id');

    // Bind values
    $this->db->bind(':order_id', $data['order_id']);
    $this->db->bind(':payment_type', $data['formType']);
    $this->db->bind(':tracking_no', $data['trackingNumber']);
   
    $this->db->bind(':status_order_details', "processing");

    // Execute
    if ($this->db->execute()) {
        return true;
    } else {
        return false;
    }
}

// public function displayOrder(){
//   $this->db->query('SELECT * FROM orders WHERE payment_type="onlineDeposit"');
//     return $this->db->resultSet();
// }

    public function findNewBooksByTime(){
      $this->db->query('SELECT * FROM books WHERE status="approval" AND type="new" ORDER BY created_at DESC');
      return $this->db->resultSet();
    }
    public function findUsedBooksByTime($customer_id){
      $this->db->query('SELECT books.*, customers.user_id AS customer_user_id FROM books INNER JOIN customers ON books.customer_id = customers.customer_id WHERE  books.customer_id != :customer_id AND books.status = "approval" AND books.type = "used" ORDER BY books.created_at DESC');
      $this->db->bind(':customer_id',$customer_id);
      return $this->db->resultSet();
    }


    public function findUsedBookById($book_id) {
      // $this->db->query('SELECT * from books WHERE book_id=:book_id');

      $this->db->query('SELECT books.*, customers.user_id AS customer_user_id FROM books INNER JOIN customers ON books.customer_id = customers.customer_id WHERE books.book_id=:book_id ');
      $this->db->bind(':book_id',$book_id);
      $row = $this->db->single();
      return $row;
    }

    public function findBooksByCategory($category) {
      $this->db->query('SELECT * FROM books WHERE status="approval" AND type="new" AND category=:category');
      $this->db->bind(':category',$category);
      return $this->db->resultSet();
    }    


    public function searchNewBooks($inputText){
      $this->db->query("SELECT book_id, book_name, ISBN_no, author, img1,price
      FROM books 
      WHERE (book_name LIKE '%$inputText%' OR ISBN_no LIKE '%$inputText%' OR author LIKE '%$inputText%') 
      AND type = 'new' AND status = 'approval' ");
      
      $results = $this->db->resultSet();
      return $results;
    }


    public function Profile($data) {
      $fullName = $data['first_name'] . ' ' . $data['last_name'];
      $this->db->query('UPDATE customers 
                  SET profile_img = :profile_img,
                  name = "' . $fullName . '",
                  first_name = :first_name,
                  last_name = :last_name,
                  email = :email,
                  contact_number = :contact_number,
                  postal_name = :postal_name,
                  street_name = :street_name,
                  town = :town,
                  district = :district,
                  postal_code = :postal_code,
                  account_name = :account_name,
                  account_no = :account_no, 
                  bank_name = :bank_name,
                  branch_name = :branch_name
                  WHERE customer_id = :customer_id');
      // Bind values

      // $this->db->bind(':name', $fullName);
      $this->db->bind(':customer_id',$data['customer_id']);
      $this->db->bind(':profile_img',$data['profile_img']);
      $this->db->bind(':first_name',$data['first_name']);
      $this->db->bind(':last_name',$data['last_name']);
      $this->db->bind(':email',$data['email']);
      $this->db->bind(':contact_number',$data['contact_number']);
      $this->db->bind(':postal_name',$data['postal_name']);
      $this->db->bind(':street_name',$data['street_name']);
      $this->db->bind(':town',$data['town']);
      $this->db->bind(':district',$data['district']);
      $this->db->bind(':postal_code',$data['postal_code']);
      $this->db->bind(':account_name',$data['account_name']);
      $this->db->bind(':account_no',$data['account_no']);
      $this->db->bind(':bank_name',$data['bank_name']);
      $this->db->bind(':branch_name',$data['branch_name']);
      // Execute
      if ($this->db->execute()) {
          return true;
      } else {
          return false;
      }

    }

    public function searchUsedBooks($inputText, $customer_id){
      $this->db->query("SELECT book_id, book_name, ISBN_no, author, img1,price
      FROM books 
      WHERE (book_name LIKE '%$inputText%' OR ISBN_no LIKE '%$inputText%' OR author LIKE '%$inputText%') 
      AND type = 'used' AND status = 'approval' AND customer_id != :customer_id");
      
      $this->db->bind(':customer_id', $customer_id);
      $results = $this->db->resultSet();
      return $results;
    }

    public function searchUsedBooksWithoutLoggedIn($inputText){
      $this->db->query("SELECT book_id, book_name, ISBN_no, author, img1,price
      FROM books 
      WHERE (book_name LIKE '%$inputText%' OR ISBN_no LIKE '%$inputText%' OR author LIKE '%$inputText%') 
      AND type = 'used' AND status = 'approval' ");
      
      $results = $this->db->resultSet();
      return $results;
    }

    public function searchExchangeBooksWithoutLoggedIn($inputText){
      $this->db->query("SELECT book_id, book_name, ISBN_no, author, img1,price
      FROM books 
      WHERE (book_name LIKE '%$inputText%' OR ISBN_no LIKE '%$inputText%' OR author LIKE '%$inputText%') 
      AND type = 'exchanged' AND status = 'approval' ");
      
      $results = $this->db->resultSet();
      return $results;
    }

    public function searchExchangeBooks($inputText, $customer_id){
      $this->db->query("SELECT book_id, book_name, ISBN_no, author, img1,price
      FROM books 
      WHERE (book_name LIKE '%$inputText%' OR ISBN_no LIKE '%$inputText%' OR author LIKE '%$inputText%') 
      AND type = 'exchanged' AND status = 'approval' AND customer_id != :customer_id ");
      
      $this->db->bind(':customer_id', $customer_id);
      $results = $this->db->resultSet();
      return $results;
    }

    public function searchContent($inputText, $customer_id){
      $this->db->query("SELECT content_id, topic, img, text
      FROM content 
      WHERE (topic LIKE '%$inputText%' OR text LIKE '%$inputText%')
      AND status = 'approval' AND customer_id != :customer_id");
      
      $this->db->bind(':customer_id', $customer_id);
      $results = $this->db->resultSet();
      return $results;
    }


public function editOrderCardPayment($data){
  $this->db->query('UPDATE orders o
                      JOIN order_details od ON o.order_id = od.order_id
                      SET 
                          o.payment_type = :payment_type,
                          o.tracking_no = :tracking_no,
                         
                          od.status = :status_order_details
                      WHERE o.order_id = :order_id');

    // Bind values
    $this->db->bind(':order_id', $data['order_id']);
    $this->db->bind(':payment_type', $data['formType']);
    $this->db->bind(':tracking_no', $data['trackingNumber']);
  
    $this->db->bind(':status_order_details', "processing");

    // Execute
    if ($this->db->execute()) {
        return true;
    } else {
        return false;
    }
}


public function findContentByCusId($customer_id){
  $this->db->query('SELECT * FROM content  WHERE customer_id = :customer_id AND status="approval"');
  $this->db->bind(':customer_id', $customer_id);
  return $this->db->resultSet();
  // $row = $this->db->single();
  // return $row;
}
public function findContent(){
  $this->db->query('SELECT * FROM content WHERE status="approval" ');
 
  return $this->db->resultSet();
}

public function findContentByNotCusId($customer_id){
  $this->db->query('SELECT * FROM content  WHERE customer_id != :customer_id AND status="approval"');
  $this->db->bind(':customer_id', $customer_id);
  return $this->db->resultSet();
  // $row = $this->db->single();
  // return $row;
}
public function ChangeProfImage($data) {
  $this->db->query('UPDATE customers 
              SET profile_img = :profile_img
              WHERE customer_id = :customer_id');
            
    $this->db->bind(':customer_id',$data['customer_id']);
    $this->db->bind(':profile_img',$data['profile_img']);

    if ($this->db->execute()) {
        return true;
    } else {
        return false;
    }
}
public function  deleteFromCart($cart_id){
  $this->db->query('DELETE  from cart WHERE cart_id=:cart_id');
  $this->db->bind(':cart_id',$cart_id);
  $this->db->execute();

  // Check for row count affected
  if ($this->db->rowCount() > 0) {
      return true;
  } else {
      return false;
  }
}
public function addReview($data){
  $this->db->query('INSERT INTO reviews(book_id,customer_id,review,rate) VALUES(:book_id, :customer_id, :review, :rate)');
  $this->db->bind(':book_id',$data['book_id']);
  $this->db->bind(':customer_id',$data['customer_id']);
  $this->db->bind(':review',$data['review']);
  $this->db->bind(':rate',$data['rate']);
  
  return $this->db->execute();

}
public function recommendBooks($customerId) {
  // Initialize an empty array to store recommended books
  $recommendedBooks = [];
  $orderCategories = $this->getCategoriesFromOrders($customerId);
  $cartCategories = $this->getCategoriesFromCart($customerId);
  $allOrdersCategories = $this->getCategoriesFromAllOrders();
  $categories = array_unique(array_merge($orderCategories, $cartCategories, $allOrdersCategories));

  // Retrieve books for each category
  foreach ($categories as $category) {
      $booksQuery = $this->db->query('SELECT * FROM books WHERE category = :category AND type="new"');
      $this->db->bind(':category', $category);
      $books = $this->db->resultSet();

      // Check the number of books for each category
      if (count($books) > 3) {
          // If more than 3 books, retrieve only the first three books
          $recommendedBooks[$category] = array_slice($books, 0, 3);
      } else {
          // If less than or equal to 3 books, retrieve all books
          $recommendedBooks[$category] = $books;
      }
  }

  // Return the array of recommended books
  return $recommendedBooks;
}

// Helper function to get categories from a customer's orders
private function getCategoriesFromOrders($customerId) {
  $categories = [];
  $ordersQuery = $this->db->query('SELECT DISTINCT b.category 
                                  FROM orders o
                                  JOIN order_details od ON o.order_id = od.order_id
                                  JOIN books b ON od.book_id = b.book_id
                                  WHERE o.customer_id = :customer_id');
  $this->db->bind(':customer_id', $customerId);
  $result = $this->db->resultSet();
  foreach ($result as $row) {
      $categories[] = $row->category;
  }
  return $categories;
}

// Helper function to get categories from a customer's cart
private function getCategoriesFromCart($customerId) {
  $categories = [];
  $cartQuery = $this->db->query('SELECT DISTINCT b.category 
                                  FROM cart c
                                  JOIN books b ON c.book_id = b.book_id
                                  WHERE c.customer_id = :customer_id');
  $this->db->bind(':customer_id', $customerId);
  $result = $this->db->resultSet();
  foreach ($result as $row) {
      $categories[] = $row->category;
  }
  return $categories;
}
// Helper function to get categories from all users' orders
private function getCategoriesFromAllOrders() {
  $categories = [];
  $ordersQuery = $this->db->query('SELECT DISTINCT b.category 
                                  FROM orders o
                                  JOIN order_details od ON o.order_id = od.order_id
                                  JOIN books b ON od.book_id = b.book_id');
  $result = $this->db->resultSet();
  foreach ($result as $row) {
      $categories[] = $row->category;
  }
  return $categories;
}


public function topSelling(){
  $recommendedBooks = [];

  $cartCategories = $this->getCategoriesFromAllCart();
  $allOrdersCategories = $this->getCategoriesFromAllOrders();

  $categories = array_unique(array_merge($cartCategories, $allOrdersCategories));

  foreach ($categories as $category) {
    $booksQuery = $this->db->query('SELECT * FROM books WHERE category = :category AND type="new"');
    $this->db->bind(':category', $category);
    $books = $this->db->resultSet();

    if (count($books) > 3) {
       
        $recommendedBooks[$category] = array_slice($books, 0, 3);
    } else {
        $recommendedBooks[$category] = $books;
    }
}
return $recommendedBooks;
}

private function getCategoriesFromAllCart() {
  $categories = [];
  $cartQuery = $this->db->query('SELECT DISTINCT b.category 
                                  FROM cart c
                                  JOIN books b ON c.book_id = b.book_id
                                  WHERE b.type="new"');
 
  $result = $this->db->resultSet();
  foreach ($result as $row) {
      $categories[] = $row->category;
  }
  return $categories;
}


public function getAverageRatingByBookId($book_id) {
 
  $this->db->query('SELECT AVG(rate) AS average_rating , COUNT(*) AS total_reviews  FROM reviews WHERE book_id = :book_id');
  $this->db->bind(':book_id', $book_id);
  return $this->db->single(); // Assuming you only expect one result
}

public function getAverageRatingByContentId($content_id) {
 
  $this->db->query('SELECT AVG(rate) AS average_rating , COUNT(*) AS total_reviews  FROM content_review WHERE content_id = :content_id');
  $this->db->bind(':content_id', $content_id);
  return $this->db->single(); // Assuming you only expect one result
}

  public function countStar_1($book_id){
    $this->db->query('SELECT COUNT(*) AS total_1 FROM reviews WHERE book_id = :book_id AND rate=:rate ');
    $this->db->bind(':book_id', $book_id);
    $this->db->bind(':rate', "1");
    return $this->db->single();
  }
  public function countStar_2($book_id){
    $this->db->query('SELECT COUNT(*) AS total_2 FROM reviews WHERE book_id = :book_id AND rate=:rate ');
    $this->db->bind(':book_id', $book_id);
    $this->db->bind(':rate', "2");
    return $this->db->single();
  }
  public function countStar_3($book_id){
    $this->db->query('SELECT COUNT(*) AS total_3 FROM reviews WHERE book_id = :book_id AND rate=:rate ');
    $this->db->bind(':book_id', $book_id);
    $this->db->bind(':rate', "3");
    return $this->db->single();
  }
  public function countStar_4($book_id){
    $this->db->query('SELECT COUNT(*) AS total_4 FROM reviews WHERE book_id = :book_id AND rate=:rate ');
    $this->db->bind(':book_id', $book_id);
    $this->db->bind(':rate', "4");
    return $this->db->single();
  }
  public function countStar_5($book_id){
    $this->db->query('SELECT COUNT(*) AS total_5 FROM reviews WHERE book_id = :book_id AND rate=:rate ');
    $this->db->bind(':book_id', $book_id);
    $this->db->bind(':rate', "5");
    return $this->db->single();
  }
  public function countStar_1c($content_id){
    $this->db->query('SELECT COUNT(*) AS total_1 FROM content_review WHERE content_id = :content_id AND rate=:rate ');
    $this->db->bind(':content_id', $content_id);
    $this->db->bind(':rate', "1");
    return $this->db->single();
  }
  public function countStar_2c($content_id){
    $this->db->query('SELECT COUNT(*) AS total_2 FROM content_review WHERE content_id = :content_id AND rate=:rate ');
    $this->db->bind(':content_id', $content_id);
    $this->db->bind(':rate', "2");
    return $this->db->single();
  }
  public function countStar_3c($content_id){
    $this->db->query('SELECT COUNT(*) AS total_3 FROM content_review WHERE content_id = :content_id AND rate=:rate ');
    $this->db->bind(':content_id', $content_id);
    $this->db->bind(':rate', "3");
    return $this->db->single();
  }
  public function countStar_4c($content_id){
    $this->db->query('SELECT COUNT(*) AS total_4 FROM content_review WHERE content_id = :content_id AND rate=:rate ');
    $this->db->bind(':content_id', $content_id);
    $this->db->bind(':rate', "4");
    return $this->db->single();
  }
  public function countStar_5c($content_id){
    $this->db->query('SELECT COUNT(*) AS total_5 FROM content_review WHERE content_id = :content_id AND rate=:rate ');
    $this->db->bind(':content_id', $content_id);
    $this->db->bind(':rate', "5");
    return $this->db->single();
  }
  public function findReviewsByBookId($book_id){
    $this->db->query('SELECT r.*, c.first_name AS name, c.profile_img AS profile_img FROM reviews r JOIN customers c ON r.customer_id = c.customer_id WHERE book_id = :book_id');
    $this->db->bind(':book_id', $book_id);
    
    return $this->db->resultSet();
  }

  public function markReview($reviewId) {
    $this->db->query('UPDATE content_review
              SET help = help + 1 
              WHERE review_id = :review_id');
            
    $this->db->bind(':review_id', $reviewId);

    if ($this->db->execute()) {
        return true;
    } else {
        return false;
    }
}

  
public function getRating($book_id) {
  $query = "SELECT 
            CONCAT(rate, ' Star') AS rating, 
            COUNT(*) AS count,
            COUNT(*) * 100 / (SELECT COUNT(*) FROM reviews WHERE book_id = :book_id) AS percentage 
            FROM  reviews 
            WHERE book_id = :book_id 
            GROUP BY rate 
            ORDER BY rate ASC";
  $this->db->query($query);
  $this->db->bind(':book_id', $book_id);
  $this->db->execute();
}
public function addContentReview($data){
  $this->db->query('INSERT INTO content_review(content_id,customer_id,review,rate) VALUES(:content_id, :customer_id, :review, :rate)');
  $this->db->bind(':content_id',$data['content_id']);
  $this->db->bind(':customer_id',$data['customer_id']);
  $this->db->bind(':review',$data['review']);
  $this->db->bind(':rate',$data['rate']);
  
  return $this->db->execute();

}

public function findReviewsByContentId($content_id, $category) {
  if ($category === 'recent') {
      $sql = "SELECT r.*, c.first_name AS name, c.profile_img AS profile_img 
              FROM content_review r 
              JOIN customers c ON r.customer_id = c.customer_id 
              WHERE content_id = :content_id 
              ORDER BY r.time DESC";
  } elseif ($category === 'relevant') {
      $sql = "SELECT r.*, c.first_name AS name, c.profile_img AS profile_img 
              FROM content_review r 
              JOIN customers c ON r.customer_id = c.customer_id 
              WHERE content_id = :content_id 
              ORDER BY r.help DESC";
  } else {
      return []; 
  }
  $this->db->query($sql);
  $this->db->bind(':content_id', $content_id);
  return $this->db->resultSet();
}


public function getOngoingChallenges($user_id){
  $this->db->query('SELECT q.quiz_id, q.title, q.date, q.end_date, q.description, q.time_limit, q.img,
                    h.user_id AS attempted_by_user
                    FROM quiz q 
                    LEFT JOIN history h ON q.quiz_id = h.quiz_id AND h.user_id = :user_id
                    WHERE q.end_date > NOW()');
  $this->db->bind(':user_id',$user_id);
  return $this->db->resultSet();
}

public function addQuizAttempt($quiz_id, $user_id){
  // Check if the record already exists
  $this->db->query('SELECT * FROM history WHERE quiz_id = :quiz_id AND user_id = :user_id');
  $this->db->bind(':quiz_id', $quiz_id);
  $this->db->bind(':user_id', $user_id);
  $this->db->execute();

    // If a record already exists, return false
    if ($this->db->rowCount() > 0) {
        return false;
    }

    // If the record doesn't exist, insert a new record
    $this->db->query('INSERT INTO history(quiz_id, user_id, score) VALUES (:quiz_id, :user_id, 0)');
    $this->db->bind(':quiz_id', $quiz_id);
    $this->db->bind(':user_id', $user_id);

    // Execute the query
    if ($this->db->execute()) {
        return true;
    } else {
        return false;
    }
}


public function incrementScore($user_id) {
  $this->db->query('UPDATE history SET score = score + 2 WHERE user_id = :user_id');
  $this->db->bind(':user_id',$user_id);
  if ($this->db->execute()) {
    return true;
  } else {
    return false;
  }
}

public function getQuizQuestion($quiz_id,$question_id){
  $this->db->query('SELECT * FROM quiz_questions WHERE quiz_id=:quiz_id AND question_id=:question_id');
  $this->db->bind(':quiz_id',$quiz_id);
  $this->db->bind(':question_id',$question_id);
  return $this->db->resultSet();
}

public function getAllQuizQuestions($quiz_id){
  $this->db->query('SELECT * FROM quiz_questions WHERE quiz_id=:quiz_id');
  $this->db->bind(':quiz_id',$quiz_id);
  return $this->db->resultSet();
}

public function getQuizScore($quiz_id,$user_id){
  $this->db->query('SELECT score FROM history WHERE quiz_id=:quiz_id AND user_id=:user_id');
  $this->db->bind(':quiz_id',$quiz_id);
  $this->db->bind(':user_id',$user_id);
  return $this->db->resultSet();
}

public function getQuizDetails(){
  $this->db->query('SELECT u.name, s.user_id, SUM(s.score) AS total_score
  FROM history s
  INNER JOIN users u ON s.user_id = u.user_id
  GROUP BY u.user_id
  ORDER BY total_score ASC');

  return $this->db->resultSet();
}

  public function findDetailsByCartId($cartId){
    $this->db->query('SELECT c.*, b.*, (c.quantity * b.price) AS total_price, (c.quantity * (b.price - (b.price * b.discounts * 0.01))) AS total_price_with_discounts, b.quantity AS maxQuantity, c.quantity AS nowQuantity, b.type AS type, b.book_id AS book_id, b.price AS perOnePrice, b.weight AS perOneWeight
    FROM cart c 
    JOIN books b ON c.book_id = b.book_id 
    WHERE c.cart_id = :cart_id
    ');
    $this->db->bind(':cart_id', $cartId);
    return $this->db->resultSet();
  }


  public function findBookById($book_id){
    $this->db->query('SELECT * from books WHERE book_id=:book_id ');
    $this->db->bind(':book_id',$book_id);
    return $this->db->resultSet();
    // $row = $this->db->single();
    // return $row;
  }
  // public function findBookById($book_id){
  //   $this->db->query('SELECT b.*, p.user_id AS pub_user_id FROM books b JOIN publishers p ON b.publisher_id = p.publisher_id WHERE book_id = :book_id');
  //   $this->db->bind(':book_id', $book_id);

  //   return $this->db->resultSet();
  //   // $row = $this->db->single();
  //   // return $row;
  // }

  public function findAllUsedBooks() {
    $this->db->query('SELECT * FROM books WHERE status="approval" AND type="used" ORDER BY created_at DESC');
    return $this->db->resultSet();
  }

  public function findAllExchangedBook() {
    $this->db->query('SELECT * FROM books WHERE status="approval" AND type="exchanged" ORDER BY created_at DESC');
    return $this->db->resultSet();
  }


  public function findAllEvents() {
    $this->db->query('SELECT * FROM events WHERE status="Approved"');
    return $this->db->resultSet();
  }

  public function findCharityEvents() {
    $this->db->query('SELECT * FROM charity_event');
    return $this->db->resultSet();
  }

  public function FindRedeemPoints($customer_id){
    $this->db->query('SELECT redeem_points FROM customers WHERE customer_id=:customer_id');
    $this->db->bind(':customer_id',$customer_id);
    return $this->db->single();
  }

  public function updateRedeem($customer_id, $totalRedeem) {
    $this->db->query('UPDATE customers SET redeem_points = redeem_points - :redeem_points WHERE customer_id = :customer_id');
    $this->db->bind(':redeem_points', $totalRedeem); // Removed space after ':redeem_points'
    $this->db->bind(':customer_id', $customer_id);
    if ($this->db->execute()) {
        return true;
    } else {
        return false;
    }
}
  public function updateQuantity( $quantity, $bookId) {
    $this->db->query('UPDATE books SET quantity = quantity - :quantity WHERE book_id = :book_id');
    $this->db->bind(':quantity', $quantity); 
    $this->db->bind(':book_id', $bookId);
    if ($this->db->execute()) {
        return true;
    } else {
        return false;
    }
  }
public function getTopRatedContentOfWeek($startOfWeek, $endOfWeek) {
 

  $this->db->query("SELECT content.*, SUM(content_review.rate) AS total_rating FROM content INNER JOIN content_review ON content.content_id= content_review.content_id WHERE WEEK(content_review.time) = WEEK(:startOfWeek) AND YEAR(content_review.time) = YEAR(:startOfWeek) AND content.status = 'approval' GROUP BY content.content_id ORDER BY total_rating DESC;");
  $this->db->bind(':startOfWeek', $startOfWeek);
  $this->db->bind(':endOfWeek', $endOfWeek);
  
  return $this->db->resultSet(); // Assuming you only want the top-rated content
}


  public function complaint($data) {
      $this->db->query('INSERT INTO complaint (first_name, last_name, email, contact_number, reason, other, descript, err_img, customer_id)
                                  VALUES(:first_name, :last_name, :email, :contact_number, :reason, :other, :descript, :err_img, :customer_id)');

      $this->db->bind(':first_name',$data['first_name']);
      $this->db->bind(':last_name',$data['last_name']);
      $this->db->bind(':email',$data['email']);
      $this->db->bind(':contact_number',$data['contact_number']);
      $this->db->bind(':reason',$data['reason']);
      $this->db->bind(':other',$data['other']);
      $this->db->bind(':descript',$data['descript']);
      $this->db->bind(':err_img',$data['err_img']);
      $this->db->bind(':customer_id',$data['user_id']);

      // execute
      if($this->db->execute()){
        return true;
      }else{
          return false;
      }   
  }

  public function AddDonateBooks($data) {
    $this->db->query('INSERT INTO donate_books (first_name, last_name, email, contact_number, description, book_types, quantity, customer_id, charity_event_id)
                                VALUES(:first_name, :last_name, :email, :contact_number, :description, :book_types, :quantity, :customer_id, :charity_event_id)');

    $this->db->bind(':first_name',$data['first_name']);
    $this->db->bind(':last_name',$data['last_name']);
    $this->db->bind(':email',$data['email']);
    $this->db->bind(':contact_number',$data['contact_number']);
    $this->db->bind(':description',$data['description']);
    $this->db->bind(':book_types',$data['book_types']);
    $this->db->bind(':quantity',$data['quantity']);
    $this->db->bind(':customer_id',$data['customer_id']);
    $this->db->bind(':charity_event_id',$data['charity_event_id']);

    // execute
    if($this->db->execute()){
      return true;
    }else{
        return false;
    }   
  }
  // public function Addtofavorie($item_id, $customer_id, $topic, $category) {
  //   $this->db-query('INSERT INTO favorite (item_id, customer_id, topic, category)
  //                               VALUE (:item_id, :customer_id, :topic, :category)');
  
  //   $this->db->bind(':item_id',$item_id);
  //   $this->db->bind(':customer_id',$customer_id);
  //   $this->db->bind(':topic',$topic);
  //   $this->db->bind(':category',$category);

  //   // execute
  //   if($this->db->execute()){
  //     return true;
  //   }else{
  //       return false;
  //   }   
  // }

  public function Addtofavorite($item_id, $customer_id, $topic, $category) {
    try {
        $this->db->query('INSERT INTO favorite (item_id, customer_id, topic, category) VALUES (:item_id, :customer_id, :topic, :category)');
        $this->db->bind(':item_id',$item_id);
        $this->db->bind(':customer_id',$customer_id);
        $this->db->bind(':topic',$topic);
        $this->db->bind(':category',$category);

        return $this->db->execute();
    } catch (\Exception $e) {
        // Handle the exception (e.g., log it, display an error message)
        echo 'Error: ' . $e->getMessage();
        return false;
    }
  }
  public function updateReviewHelpful($reviewId){
    $this->db->query('UPDATE content_review SET help = help + 1 WHERE review_id = :reviewId');
    $this->db->bind(':reviewId', $reviewId); // Corrected variable name
    if($this->db->execute()){
        return true;
    } else {
        return false;
    }   
}
public function updateReviewHelpfulBooks($reviewId){
  $this->db->query('UPDATE reviews SET help = help + 1 WHERE review_id = :reviewId');
  $this->db->bind(':reviewId', $reviewId); // Corrected variable name
  if($this->db->execute()){
      return true;
  } else {
      return false;
  }   
}
public function checkCart($bookId) {
  $this->db->query('SELECT COUNT(*) AS total FROM cart WHERE book_id = :book_id');
  $this->db->bind(':book_id', $bookId);
  $this->db->execute();
  $result = $this->db->single();
  if ($result['total'] == 0) {
      return true;
  } else {
      return false;
  }
}
public function addNotification($data){
  $this->db->query('INSERT INTO messages (sender_id, user_id, topic,message,sender_name) VALUES (:sender_id,  :user_id, :topic, :message, :sender_name)');
  $this->db->bind(':sender_id', $data['sender_id']);
  $this->db->bind(':user_id', $data['reciever_id']);
  $this->db->bind(':topic', $data['topic']);
  $this->db->bind(':message', $data['message']);
  $this->db->bind(':sender_name', $data['sender_name']);
  if($this->db->execute()){
      return true;
    }else{
      return false;
    }

}

  public function findNoOfUsedBooksById($customer_id) {
      $this->db->query('SELECT COUNT(*) AS count FROM books WHERE customer_id=:customer_id AND status="approval" AND type="used"');
      $this->db->bind(':customer_id',$customer_id);
      $result = $this->db->single();
      return $result->count;
  }

  public function findNoOfExchangeBooksById($customer_id) {
      $this->db->query('SELECT COUNT(*) AS count FROM books WHERE customer_id=:customer_id AND status="approval" AND type="exchanged"');
      $this->db->bind(':customer_id',$customer_id);
      $result = $this->db->single();
      return $result->count;
  }

  public function findNoOfContentsById($customer_id) {
      $this->db->query('SELECT COUNT(*) AS count FROM content WHERE customer_id=:customer_id AND status="approval"');
      $this->db->bind(':customer_id',$customer_id);
      $result = $this->db->single();
      return $result->count;
  }

  public function findNoOfEventsById($user_id) {
      $this->db->query('SELECT COUNT(*) AS count FROM events WHERE user_id=:user_id');
      $this->db->bind(':user_id',$user_id);
      $result = $this->db->single();
      return $result->count;
  }

  public function findNoOfBuyNewBooksById($customer_id) {
    $this->db->query('SELECT COUNT(orders.order_id) AS num_delivered_orders_new_books
                      FROM orders
                      JOIN order_details ON orders.order_id = order_details.order_id
                      JOIN books ON order_details.book_id = books.book_id
                      WHERE orders.customer_id = :customer_id
                      AND order_details.status = "delivered"
                      AND books.type = "new"');
    $this->db->bind(':customer_id',$customer_id);
    $result = $this->db->single();
    return $result->num_delivered_orders_new_books;
  }

  public function findNoOfBuyUsedBooksById($customer_id) {
    $this->db->query('SELECT COUNT(orders.order_id) AS num_delivered_orders_used_books
                      FROM orders
                      JOIN order_details ON orders.order_id = order_details.order_id
                      JOIN books ON order_details.book_id = books.book_id
                      WHERE orders.customer_id = :customer_id
                      AND order_details.status = "delivered"
                      AND books.type = "used"');
    $this->db->bind(':customer_id',$customer_id);
    $result = $this->db->single();
    return $result->num_delivered_orders_used_books;
  }

  public function findBoughtCategories($customer_id) {
    $this->db->query('SELECT b.category, COUNT(*) AS book_count
                      FROM orders o
                      JOIN order_details od ON o.order_id = od.order_id
                      JOIN books b ON od.book_id = b.book_id
                      WHERE o.customer_id = :customer_id
                      AND od.status = "delivered"
                      GROUP BY b.category;');
    $this->db->bind(':customer_id', $customer_id);
    $results = $this->db->resultSet();
    return $results;
  }

  public function findAddedCategories($customer_id) {
    $query = "SELECT category, COUNT(*) AS book_count FROM books WHERE customer_id = :customer_id AND status='approval' GROUP BY category";
    $this->db->query($query);
    $this->db->bind(':customer_id', $customer_id);
    return $this->db->resultSet();
  }

  public function findContentPoints($customer_id) {
    $this->db->query('SELECT content_point FROM customers WHERE customer_id = :customer_id');
    $this->db->bind(':customer_id', $customer_id);
    $result = $this->db->single();
    return isset($result->content_point) ? (int)$result->content_point : 0;
  }

  public function findChallengePoints($customer_id) {
    $this->db->query('SELECT challnege_point FROM customers WHERE customer_id = :customer_id');
    $this->db->bind(':customer_id', $customer_id);
    $result = $this->db->single();
    return isset($result->challnege_point) ? (int)$result->challnege_point : 0;
  }

  public function findDonateBooks($customer_id) {
    $this->db->query('SELECT SUM(quantity) AS donate_book_count  FROM donate_books WHERE customer_id = :customer_id');
    $this->db->bind(':customer_id', $customer_id);
    // return $this->db->resultSet();
    $result = $this->db->single();
    return isset($result->donate_book_count) ? (int)$result->donate_book_count : 0;
  }

  public function makeAsRead($message_id) {
    $this->db->query("UPDATE messages SET status = 'read' WHERE message_id = :message_id");
    $this->db->bind(':message_id', $message_id);
    return $this->db->execute();
  }
}
