//戻るボタン
function pageback(){
    history.back();
}

function clear1() {
  if(window.confirm('本当に削除しますか？')){
    console.log('success');
    var textForm1 = document.getElementById("usrnum");
    //var textForm2 = document.getElementById("usrname");
    //var textForm3 = document.getElementById("gender");
    //var textForm4 = document.getElementById("year");
    var textForm5 = document.getElementById("booknum");
    //var textForm6 = document.getElementById("title");
    //var textForm7 = document.getElementById("aname");
    textForm1.value = '';
    //textForm2.value = '';
    //textForm3.value = '';
    //textForm4.value = '';
    textForm5.value = '';
    //textForm6.value = '';
    //textForm7.value = '';
  }
}

function writeLock1(){
  var lock1 = document.getElementById("usrnum");
  if(lock1.readOnly == true){
    console.log('a');
    lock1.readOnly = false;
  }else{
    console.log('b');
    lock1.readOnly = true;
  }
}

function writeLock2(){
  var lock2 = document.getElementById("booknum");
  if(lock2.readOnly == true){
    lock2.readOnly = false;
  }else{
    lock2.readOnly = true;
  }
} 



