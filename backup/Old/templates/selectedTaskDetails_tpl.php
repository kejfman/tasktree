 <?php
    require_once '../entryPoint.php';
    require_once '../class/Task.php';

    if (isset($_GET['taskID'])) {
        $task = new Task($db_connect, $_GET['taskID']);
    }

    ?>


 <div class="shadow card">
     <div class="card-header bg-secondary text-center">
         <font size="5" class="text-light"><b><?= $task->TaskNumber ?></b></font>
     </div>
     <div class="card-body">
         <table class="table table-striped table-sm" style="font-size: 12px;">
             <tbody>
                 <tr>
                     <td width="30%">Faza wykonania</td>
                     <td><?= $task->TaskType ?></td>
                 </tr>
                 <tr>
                     <td width="30%">Grupa wsparcia</td>
                     <td><?= $task->TaskOwner ?></td>
                 </tr>
                 <tr>
                     <td width="30%">Utworzono</td>
                     <td><?= $task->CreateDateTime ?></td>
                 </tr>
                 <?php
                    if ($task->Done == "1") {
                        ?>
                     <tr>
                         <td width="30%">Zakończono</td>
                         <td><?= $task->DoneDateTime ?></td>
                     </tr>
                 <?php
                    } else {
                        ?>
                     <tr>
                         <td colspan="2">
                             <button id="<?= $task->id ?>" type="button" class="btn btn-sm btn-danger taskDone" style="width: 100%">Zakończ zadanie</button>
                         </td>
                     </tr>
                 <?php
                    }
                    ?>
             </tbody>
         </table>
     </div>
 </div>

 <div id="taskDet"></div>


 <script type="text/javascript">
     $(document).on('click', ".taskDone", function() {
         var taskDone = $(this).attr("id");
         $("#taskDet").load("scripts/setDoneStatus_Task_.php?taskID=" + taskDone, function(responseTxt, statusTxt, xhr) {
             if (statusTxt == "success")
                 $("#taskDet").load("templates/selectedTaskDetails_tpl.php?taskID=" + taskDone, function(responseTxt, statusTxt, xhr) {
                     if (statusTxt == "error")
                         alert("Błąd! Skontaktuj się z administratorem!");
                 });
             document.getElementById("" + taskDone + "").classList = "btn btn-sm btn-danger btn-task";
             if (statusTxt == "error")
                 alert("Błąd! Skontaktuj się z administratorem!");
         });
     });
 </script>