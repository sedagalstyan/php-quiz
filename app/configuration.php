<?php

if($_GET['cmd'] == 'loadCategories'){
    if(isset($_SESSION['user_answer'])){
        session_unset($_SESSION['user_answer']);
    }
    $dom = '';
    
    $quizzes = $con->prepare("SELECT * FROM `categories`");
    $quizzes->execute();
    
    $dom .= '<div class="categories">';
    $dom .= '<div class="row">';
    
    while($quiz_row = $quizzes->fetch()){
        $id = $quiz_row['id'];
        
        $language = trim(htmlspecialchars($quiz_row['language']));
        $language_hexCol = trim(htmlspecialchars($quiz_row['language-HexColor']));
        $text_hexCol = trim(htmlspecialchars($quiz_row['text-HexColor']));
        $status = trim(htmlspecialchars($quiz_row['status']));
        
        $dom .= '<div class="language '.$status.'" data-value="'.$language.'" data-id="'.$id.'" style="background-color: '.$language_hexCol.'; color: '.$text_hexCol.';"><span>'.$language.'</span></div>';

    }
    
    $dom .= '</div>';
    $dom .= '</div>';
    
    $response = array('dom' => $dom);
    $response_json = json_encode($response);
    echo $response_json;
    exit;
}
if($_GET['cmd'] == 'loadQuestions'){
    $questionId = $_POST['questionId'];
    $questionCount = $_POST['questionCount'];
    $category_id = $_SESSION['category'];

    $rowCount = 0;
    
    $lastId = $con->prepare("SELECT * FROM `questions` WHERE `category_id` = '$category_id'");
    $lastId->execute();
    while($lastId_row = $lastId->fetch()){
        $rowCount++;
    }
    
    $dom = '';
    if($questionId == ''){
        $quizzes = $con->prepare("SELECT * FROM `questions` WHERE `category_id` = '$category_id' LIMIT 1");
        $quizzes->execute();
    }else{
        $quizzes = $con->prepare("SELECT * FROM `questions` WHERE `id` = '$questionId' && `category_id` = '$category_id' LIMIT 1");
        $quizzes->execute();
    }
    
    $dom .= '<div class="quizzes-container">';
    $dom .= '<div class="undo"><i class="fas fa-arrow-left"></i></div>';
    while($quiz_row = $quizzes->fetch()){
        $id = $quiz_row['id'];
        $question = $quiz_row['question'];
        
        $option1 = trim(htmlspecialchars($quiz_row['option1']));
        $option2 = trim(htmlspecialchars($quiz_row['option2']));
        $option3 = trim(htmlspecialchars($quiz_row['option3']));
        $option4 = trim(htmlspecialchars($quiz_row['option4']));
        
        $dom .= '<div class="count-questions" data-id="'.$id.'" data-count="'.$questionCount.'" data-lastid="'.$rowCount.'">'.$questionCount.'/'.$rowCount.'</div>';
        $dom .= '<div class="question">'.$question.'</div>';
        $dom .= '<div class="answers">';
        $dom .= '<label><p><input type="radio" id="'.$id.'" data-count="'.$questionCount.'" name="'.$id.'" value="'.$option1.'" checkSession="'.$id.$option1.'"';
        if(isset($_SESSION['user_answer'][$id]) &&($_SESSION['user_answer'][$id] == $option1)){
            $dom .= 'checked';
        }
        $dom .= '>'.$option1.'</p></label>';
        $dom .= '<label><p><input type="radio" id="'.$id.'" data-count="'.$questionCount.'" name="'.$id.'" value="'.$option2.'" checkSession="'.$id.$option2.'"';
        if(isset($_SESSION['user_answer'][$id]) &&($_SESSION['user_answer'][$id] == $option2)){
            $dom .= 'checked';
        }
        $dom .= '>'.$option2.'</p></label>';
        $dom .= '<label><p><input type="radio" id="'.$id.'" data-count="'.$questionCount.'" name="'.$id.'" value="'.$option3.'" checkSession="'.$id.$option3.'"';
        if(isset($_SESSION['user_answer'][$id]) &&($_SESSION['user_answer'][$id] == $option3)){
            $dom .= 'checked';
        }
        $dom .= '>'.$option3.'</p></label>';
        $dom .= '<label><p><input type="radio" id="'.$id.'" data-count="'.$questionCount.'" name="'.$id.'" value="'.$option4.'" checkSession="'.$id.$option4.'"';
        if(isset($_SESSION['user_answer'][$id]) &&($_SESSION['user_answer'][$id] == $option4)){
            $dom .= 'checked';
        }
        $dom .= '>'.$option4.'</p></label>';
        $dom .= '</div>';
    }
    
    $dom .= '</div>';
        
    $response = array('dom' => $dom);
    $response_json = json_encode($response);
    echo $response_json;
    exit;
}
if($_GET['cmd'] == 'checkAnswer'){
    $correctAnswer = 0;
    $wrongAnswer = 0;
    $dom = '';
    if(isset($_SESSION['category']) && isset($_SESSION['user_answer'])){
        $category_id = $_SESSION['category'];
        $answersArray = $_SESSION['user_answer'];
        $rowCount = 0;
        $lastId = $con->prepare("SELECT * FROM `questions` WHERE `category_id` = '$category_id'");
        $lastId->execute();
        while($lastId_row = $lastId->fetch()){
            $id = $lastId_row['id'];
            $rowCount++;
        }
        if(isset($_SESSION['user_answer'])){
            foreach($answersArray as $id=>$val){
                $checkAnswer = $con->prepare("SELECT * FROM `questions` WHERE `id` = '$id' && `category_id` = '$category_id'");
                $checkAnswer->execute();

                while($checkAnswerRow = $checkAnswer->fetch()){
                    $answer = trim(htmlspecialchars($checkAnswerRow['answer']));

                    if(isset($_SESSION['user_answer'][$id])){
                        if($answer == $_SESSION['user_answer'][$id]){
                            $correctAnswer += 1;
                        }else{
                            $wrongAnswer += 1;
                        }
                    }
                }
            }
        }

        $ans = $correctAnswer;
        $score = round(($ans / $rowCount) * 100);

        $dom .= '<div class="progress-container">';
        $dom .= '<div class="progress-bar" data-percent="'.$score.'" data-duration="500" data-color="#b1cef5,#4b84dc"></div>';
        $dom .= '<div class="msg">';
        $dom .= '<div class="correctAnswers">Ճիշտ պատասխաններ՝ <span style="color: #8bc34a;">'.$correctAnswer.'</span></div>';
        $dom .= '<div class="wrongAnswers">Սխալ պատասխաններ՝ <span style="color: #f44336;">'.$wrongAnswer.'</span></div>';
        $dom .= '<button class="results">Տեսնել արդյունքը</a>';
        $dom .= '</div>';
    }else{
        $dom .= '0';
    }
    
    $response = array('dom' => $dom);
    $response_json = json_encode($response);
    echo $response_json;
    exit;
}
if($_GET['cmd'] == 'showResults'){
    if(isset($_SESSION['category']) && isset($_SESSION['user_answer'])){
        $category_id = $_SESSION['category'];
        $answersArray = $_SESSION['user_answer'];
    }
    
    $dom = '';
      
    $dom .= '<div class="quizzes-container">';
    $dom .= '<div class="resundo undo"><i class="fas fa-arrow-left"></i></div>';

    if(isset($_SESSION['user_answer'])){
        foreach($answersArray as $id=>$val){
            $checkAnswer = $con->prepare("SELECT * FROM `questions` WHERE `id` = '$id' && `category_id` = '$category_id'");
            $checkAnswer->execute();

            while($checkAnswerRow = $checkAnswer->fetch()){
                $id = $checkAnswerRow['id'];
                $question = $checkAnswerRow['question'];

                $option1 = trim(htmlspecialchars($checkAnswerRow['option1']));
                $option2 = trim(htmlspecialchars($checkAnswerRow['option2']));
                $option3 = trim(htmlspecialchars($checkAnswerRow['option3']));
                $option4 = trim(htmlspecialchars($checkAnswerRow['option4']));
                
                $answer = trim(htmlspecialchars($checkAnswerRow['answer']));
                
                $dom .= '<div class="result-container" style="margin-bottom: 50px;">';
                $dom .= '<div class="question">'.$question.'</div>';
                $dom .= '<div class="answers">';
                $dom .= '<label><p ';
                if($answer == $_SESSION['user_answer'][$id] &&  $_SESSION['user_answer'][$id] == $option1){
                    $dom .= 'style="background-color: #8bc34a; color: #fff; border-top: 0;"';
                }
                if($_SESSION['user_answer'][$id] == $option1){
                    $dom .= 'style="background-color: #f44336; color: #fff; border-top: 0;"';
                }
                if($answer == $option1){
                    $dom .= 'style="background-color: #8bc34a; color: #fff; border-top: 0;"';
                }
                $dom .= '><input type="radio" id="'.$id.'" name="'.$id.'" value="'.$option1.'" checkSession="'.$id.$option1.'">'.$option1.'</p></label>';
                $dom .= '<label><p ';
                if($answer == $_SESSION['user_answer'][$id] && $_SESSION['user_answer'][$id] == $option2){
                    $dom .= 'style="background-color: #8bc34a; color: #fff; border-top: 0;"';
                }
                if($_SESSION['user_answer'][$id] == $option2){
                    $dom .= 'style="background-color: #f44336; color: #fff; border-top: 0;"';
                }
                if($answer == $option2){
                    $dom .= 'style="background-color: #8bc34a; color: #fff; border-top: 0;"';
                }
                $dom .= '><input type="radio" id="'.$id.'" name="'.$id.'" value="'.$option2.'" checkSession="'.$id.$option2.'"';
                $dom .= '>'.$option2.'</p></label>';
                $dom .= '<label><p ';
                if($answer == $_SESSION['user_answer'][$id] && $_SESSION['user_answer'][$id] == $option3){
                    $dom .= 'style="background-color: #8bc34a; color: #fff; border-top: 0;"';
                }
                if($_SESSION['user_answer'][$id] == $option3){
                    $dom .= 'style="background-color: #f44336; color: #fff; border-top: 0;"';
                }
                if($answer == $option3){
                    $dom .= 'style="background-color: #8bc34a; color: #fff; border-top: 0;"';
                }
                $dom .= '><input type="radio" id="'.$id.'" name="'.$id.'" value="'.$option3.'" checkSession="'.$id.$option3.'"';
                $dom .= '>'.$option3.'</p></label>';
                $dom .= '<label><p ';
                if($answer == $_SESSION['user_answer'][$id] && $_SESSION['user_answer'][$id] == $option4){
                    $dom .= 'style="background-color: #8bc34a; color: #fff; border-top: 0;"';
                }
                if($_SESSION['user_answer'][$id] == $option4){
                    $dom .= 'style="background-color: #f44336; color: #fff; border-top: 0;"';
                }
                if($answer == $option4){
                    $dom .= 'style="background-color: #8bc34a; color: #fff; border-top: 0;"';
                }
                $dom .= '><input type="radio" id="'.$id.'" name="'.$id.'" value="'.$option4.'" checkSession="'.$id.$option4.'"';
                $dom .= '>'.$option4.'</p></label>';
                $dom .= '</div>';
                $dom .= '</div>';
            }
        }
    }
    
    $dom .= '</div>';
    
    $response = array('dom' => $dom);
    $response_json = json_encode($response);
    echo $response_json;
    session_unset($_SESSION['user_answer']);
    exit;
}
if($_GET['cmd'] == 'addCategorySession'){
    $id = $_POST['id'];
    $_SESSION['category'] = $id;
    echo $_SESSION['category'];
    exit;
}
if($_GET['cmd'] == 'addSession'){
    $id = $_POST['id'];
    $value = trim(htmlspecialchars($_POST['value']));
    $_SESSION['user_answer'][$id] = $value;
    exit;
}

?>