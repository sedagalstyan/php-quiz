loadCategories();

$('.actions').css('visibility','hidden');
$('body').on('click', '.undo', function(){
    window.location.replace('index.php');
});
$('body').on('click', '.language', function(){
    var id = $(this).data('id');
    addCategorySession(id);
    if($('.container').find('.quizzes-container').length === 0){
        questionCount = 1;
        loadQueations('', questionCount);
        setTimeout(function(){
            $('.next').css('visibility','visible');
            $('.previous').css('visibility','hidden');
        },50);
     }
});
$('body').on('click', '.answers input', function(){
    var id, value;
    var selected = $(".quizzes-container input[type=radio]:checked");
    if(selected){
        id = selected.attr('id');
        value = selected.attr('value');
        this.id = id;
        this.value = value;
    }
    addSession(id, value);
});
$('body').on('click', '.next', function(){
    var questionId = $('.count-questions').data('id'),
        questionCount = $('.count-questions').data('count'),
        lastid = $('.count-questions').data('lastid'),
        n = 1;

    if(questionCount >= n){
        $('.previous').css('visibility','visible');
    }
    if(questionCount >= lastid - 1){
        $('.next').css('visibility','hidden');
        $('.submit').css('visibility','visible');
    }
    
    questionId++;
    questionCount++;
    loadQueations(questionId,questionCount);
});
$('body').on('click', '.previous', function(){
    var questionId = $('.count-questions').data('id'),
        questionCount = $('.count-questions').data('count'),
        lastid = $('.count-questions').data('lastid'),
        n = 1;
    
    if(questionCount <= n + 1){
        $('.previous').css('visibility','hidden');
    }
    if(questionCount <= lastid){
        $('.next').css('visibility','visible');
        $('.submit').css('visibility','hidden');
    }
    
    questionId--;
    questionCount--;
    loadQueations(questionId,questionCount);
});
$('body').on('click', '.submit', function(){
    $.post('index.php?cmd=checkAnswer',function(response){ 
        try{
            var responseObj = JSON.parse(response);
        }catch(e){
            return false;
        }
        
        if(responseObj.dom == 0){
            alert('Ընտրեք գոնե մեկ պատասխան');
        }else{
            $('.previous').css('visibility','hidden');
            $('.submit').css('visibility','hidden');
            $('.container').html(responseObj.dom);
            $('.container .progress-bar').loading();
        }
    });
});
$('body').on('click', '.results', function(){
    $.post('index.php?cmd=showResults',function(response){ 
        try{
            var responseObj = JSON.parse(response);
        }catch(e){
            return false;
        }
           
        $('.container').html(responseObj.dom);
    });
});

// Functions
function loadCategories(){
    $.post('index.php?cmd=loadCategories',function(response){
        try{
            var responseObj = JSON.parse(response);
        }catch(e){
            return false;
        }
        $('.container').html(responseObj.dom);
    });
}
function loadQueations(questionId = '', questionCount = ''){
    $.post('index.php?cmd=loadQuestions', {questionId: questionId, questionCount: questionCount}, function(response){
        try{
            var responseObj = JSON.parse(response);
        }catch(e){
            return false;
        }
        
        $('.container').html(responseObj.dom);
    });
}
function addCategorySession(id){
    $.post('index.php?cmd=addCategorySession',{ id: id },function(response){
        try{
            var responseObj = JSON.parse(response);
        }catch(e){
            return false;
        }
    });
}
function addSession(id,value){
    $.post('index.php?cmd=addSession',{ id: id, value: value },function(response){
        try{
            var responseObj = JSON.parse(response);
        }catch(e){
            return false;
        }
        
    });
}