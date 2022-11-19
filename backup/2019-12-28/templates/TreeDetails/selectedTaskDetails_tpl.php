 <?php
    require_once '../../entryPoint.php';
    require_once '../../class/Task.php';

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
                             <button name="taskDone" id="<?= $task->id ?>" type="button" class="btn btn-sm btn-danger taskDone" style="width: 100%">Zamknij zadanie</button>
                         </td>
                     </tr>
                 <?php
                    }
                    ?>
             </tbody>
         </table>
     </div>
 </div>



 <script type="text/javascript">
     $(document).ready(function() {
         $(document).on('click', ".taskDone", function() {
             var taskDone = $(this).attr("id");
             var selectedTreeID = document.getElementById("selectedTreeID").value;
             var buttons = document.getElementsByName(taskDone);

             document.getElementsByName('taskDone')[0].disabled = true;
             document.getElementsByName('taskDone')[0].classList = "btn btn-sm btn-outline-danger";
             document.getElementsByName('taskDone')[0].innerHTML = "Zadanie zostało zamknięte";

             for (let index = 0; index < buttons.length; index++) {
                 const element = buttons[index];
                 element.classList = "btn btn-sm btn-warning btn-task";
             }
             $("#process").load("scripts/setDoneStatus_Task.php?taskID=" + taskDone, function(responseTxt, statusTxt, xhr) {
                 if (statusTxt == "success")
                     //  Odświeżenie wykresu:
                     $("#treeDetails").load("templates/TreeDetails/selectedTreeDetails_tpl.php?treeID=" + selectedTreeID, function(responseTxt, statusTxt, xhr) {
                         if (statusTxt == "error")
                             alert("Błąd! Skontaktuj się z administratorem!");
                     });
             });
         });
     });
 </script>