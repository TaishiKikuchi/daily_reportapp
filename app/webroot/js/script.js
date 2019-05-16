
const addwork = document.getElementById('add_work');
const addshare = document.getElementById('add_share');
const addworkblock = document.getElementById('work');
const addshareblock = document.getElementById('share');

const delWorkForm = id =>{
    let delworkblock = document.getElementById('work_' + id);
    delworkblock.innerHTML = '';
}

const delShareForm = id => {
    let delshareblock = document.getElementById('share_' + id);
    delshareblock.innerHTML = '';
}

const addform = () => {
    addWorkForm();
}

const addWorkForm = (work="") => {
    //今のままだとaddform二回以上押されると最初か最後のフォームの入力した有効にならない!!! idの数字がボタン押されるごとに増える必要あり
    let id = parseInt(addworkblock.getAttribute('value')) + 1;
    addworkblock.insertAdjacentHTML('beforeend',
    '<div id="work_'+ id +'"><div>作業内容: <span><button type="button" class="delbutton button" onclick="delWorkForm('+ id +')">削除</button></span></div>' +
    '<div class="inputtext">' +
    '<input name="data[Work]['+ id +'][subject]" class="textarea" maxlength="100" type="text" id="Work'+ id +'Subject" value="'+ work +'"></div>' +
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
    '</select></div></div></div>');

    document.getElementById('work').setAttribute('value', id);
}

const addShareForm = test => {
    console.log(test);
    let id = parseInt(addshareblock.getAttribute('value')) + 1;
    addshareblock.insertAdjacentHTML('beforeend',
    '<div id="share_'+ id +'"><div>気づき・共有: <span><button type="button" class="delbutton button" onclick="delShareForm('+ id +')">削除</button></span></div>' +
    '<div class="input textarea">' +
    '<textarea name="data[Share]['+ id +'][content]" rows="3" class="textarea" cols="30" type="text" id="Share'+ id +'content"></textarea></div></div>');
    document.getElementById('share').setAttribute('value', id);
}

addwork.addEventListener('click', addform);
addshare.addEventListener('click', addShareForm);


//client.js用
const authenticationSuccess = () => {
    console.log('Successful authentication');
};
  
const authenticationFailure = () => {
    console.log('Failed authentication');
};

window.Trello.authorize({
    type: 'popup',
    name: 'daily_reportapp',
    scope: {
      read: 'true',
      write: 'true' },
    expiration: '1day',
    success: authenticationSuccess,
    error: authenticationFailure
});


const getCardName = async(user_id) => {
    let date = new Date();
    date.setTime(date.getTime() - 1000*60*60*9);
    const month = ("0"+(date.getMonth() + 1)).slice(-2);
    const response =
        await Trello.get('/members/'+ user_id +'/actions',{
            fields: "data,date",
            since: date.getFullYear() + '-' + month + '-' + date.getDate() + 'T00:00Z'
        });

    console.log(response);
    let subjects = [];

    response.forEach((result) => {
        if (result['data']['card']) {
            subjects.push(result['data']['card']['name']);
        }
    });

    subjects = new Set(subjects);
    if(subjects.length == 0) {
        alert('取得できる作業内容がありません');
    }

    subjects.forEach((value) => {
        addWorkForm(value);
    });
    /* async使ってみたバージョン
    const createForm = async () => {
        await response.forEach((result) => {
            if (result['data']['card']) {
                subjects.push(result['data']['card']['name']);
            }
        });

        subjects = new Set(subjects);
        if(subjects.length == 0) {
            alert('取得できる作業内容がありません');
            console.log(subjects);
        }

        subjects.forEach((value) => {
            addWorkForm(value);
        });
    };
    createForm();
    */
}