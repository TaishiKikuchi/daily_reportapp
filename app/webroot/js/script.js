
const clickcontents = document.getElementsByClassName("report_container");
const add = document.getElementById('add_work');
const addblock = document.getElementById('work');

function addform(){
    console.log('test');

    addblock.insertAdjacentHTML('beforeend', '<div class="inputtext"><input name="data[Work][4][subject]"'+
    'class="textarea" maxlength="100" type="text" id="Work5Subject"></div>');
    /*
        "<\?php" + "echo $this->Html->link('削除'," +
            "[" +
            "'controller => 'reports'" + "," + 
            "'action' => 'delete_work'" +
            "], " + 
    "['class' => 'button']); ?>";*/
}

add.addEventListener('click', addform);