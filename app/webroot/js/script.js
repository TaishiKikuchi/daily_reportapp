
const clickcontents = document.getElementsByClassName("report_container");
const add = document.getElementById('add_work');
const addblock = document.getElementById('work');

function addform(){
    let id = document.getElementById('work').getAttribute('value');
    console.log(document.getElementById('work').getAttribute('value'));
    addblock.insertAdjacentHTML('beforeend',
    '<div>作業内容</div>' +
    '<div class="inputtext">' +
    '<input name="data[Work]['+ id +'][subject]" class="textarea" maxlength="100" type="text" id="Work5Subject"></div>' +
    '<div class="timeblock">' +
    '<div>開始時間 <select name="data[Work]['+ id +'][starttime][hour]" id="Work'+ id +'StarttimeHour">' +
    '<option value="08" selected="selected">8</option>' +
    '<option value="09">9</option>' +
    '<option value="10">10</option>' +
    '<option value="11">11</option>' +
    '<option value="12">12</option>' +
    '<option value="13">13</option>' +
    '<option value="14">14</option>' +
    '<option value="15">15</option>' +
    '<option value="16">16</option>' +
    '<option value="17">17</option>' +
    '<option value="18">18</option>' +
    '<option value="19">19</option>' +
    '<option value="20">20</option>' +
    '<option value="21">21</option>' +
    '<option value="22">22</option>' +
    '</select>:<select name="data[Work]['+ id +'][starttime][min]" id="Work'+ id +'StarttimeMin">' +
    '<option value="00" selected="selected">00</option>' +
    '<option value="30">30</option>' +
    '</select></div>' +
    '<div>終了時間' +
    '<select name="data[Work]['+ id +'][endtime][hour]" id="Work'+ id +'EndtimeHour">' +
    '<option value="08" selected="selected">8</option>' +
    '<option value="09">9</option>' +
    '<option value="10">10</option>' +
    '<option value="11">11</option>' +
    '<option value="12">12</option>' +
    '<option value="13">13</option>' +
    '<option value="14">14</option>' +
    '<option value="15">15</option>' +
    '<option value="16">16</option>' +
    '<option value="17">17</option>' +
    '<option value="18">18</option>' +
    '<option value="19">19</option>' +
    '<option value="20">20</option>' +
    '<option value="21">21</option>' +
    '<option value="22">22</option>' +
    '</select>:<select name="data[Work]['+ id +'][endtime][min]" id="Work'+ id +'EndtimeMin">' +
    '<option value="00" selected="selected">00</option>' +
    '<option value="30">30</option>' +
    '</select></div></div>');
}

add.addEventListener('click', addform);