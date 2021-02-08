<?php

session_start();
require_once "../../config.php";
require_once '../../vendor/autoload.php';

// Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();

$subId = $_GET['id'];
$param_id = $_GET['examId'];

/* Note: any element you append to a document must reside inside of a Section. */
// Adding an empty Section to the document...
$section = $phpWord->addSection();

$sqlQues = "SELECT exams.*, exam_paper.*, questions.* FROM exam_paper INNER JOIN exams ON exam_paper.ep_exam = exams.e_id INNER JOIN questions ON exam_paper.ep_question = questions.q_id WHERE exams.e_id = $param_id";
    
if($result = mysqli_query($link, $sqlQues)){
    if(mysqli_num_rows($result) > 0){
        $no = 0;
        while($row = mysqli_fetch_array($result)){
            $no++;
            $section->addText(
                $no.') '.$row['q_question'].'<w:br/> Mark: '.$row['q_mark']
            );
        }
    }
}


$examName = "";

$sql = "SELECT * FROM exams WHERE e_id = $param_id";

if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $examName = $row['e_name'];
        }
    }
}

// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('../../exam_files/'.$examName.'.docx');

echo"
    <script type=\"text/javascript\">
    window.alert('Your download is successful');
    </script>
";

header('Refresh: 1; URL=../view/home.php?subId='.$subId);


/* Note: we skip RTF, because it's not XML-based and requires a different example. */
/* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */