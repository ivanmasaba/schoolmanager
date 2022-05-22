function add(){
            var test = document.getElementById("test_score").value;

            var exam =  document.getElementById("exam_score").value;

            test = parseInt(test);
                if( (test<0 || test>50) ){
                  document.getElementById("test_score").value = 0;
                  test = 0;
                }else{
                document.getElementById("test_score").value = test;
                }
              
            exam = parseInt(exam);
                if( (exam<0 || exam>50) ){
                  document.getElementById("exam_score").value = 0;
                  exam = 0;
                }else{
                document.getElementById("exam_score").value = exam;
                }

            var total = parseInt(test + exam);
            
            document.getElementById("total_score").value = total;
            
      
}

