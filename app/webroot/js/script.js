
const addwork = document.getElementById('add_work');
const addworkblock = document.getElementById('work');

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
    '<input name="data[Work]['+ id +'][subject]" class="textarea" maxlength="100" type="text" id="Work'+ id +'Subject" value="'+ work +'">' +
    '</div>' + 
    '<div>振り返り<span></span></div><div class="input textarea"><textarea name="data[Work]['+ id +'][content]" rows="2" class="textarea" cols="30" id="Work'+ id +'Content"></textarea></div>' +
    '</div>');

    document.getElementById('work').setAttribute('value', id);
}

addwork.addEventListener('click', addform);


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
    const day = ("0"+date.getDate()).slice(-2);
    const response =
        await Trello.get('/members/'+ user_id +'/actions',{
            fields: "data,date",
            since: date.getFullYear() + '-' + month + '-' + day + 'T00:00Z'
        });
    console.log(response);
    let subjects = [];
    //除外試し用
    //console.log(response);
    const tlist = "z2nnPe9A";
    response.forEach((result) => {
        if (result['data']['board']['shortLink'] == tlist) {
        } else {
            if (result['data']['card']) {
                subjects.push(result['data']['card']['name']);
            }
        }
    });

    subjects = new Set(subjects);
    if(subjects.length != 0) {
        subjects.forEach((value) => {
            addWorkForm(value);
        });
    } else {
        alert('取得できる作業内容がありません');
    }
    
}
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
const getCalendar = (email) => {
    const request = new XMLHttpRequest();
    request.open("GET", "http://localhost:8080/daily_reportapp/reports/getSchedules/" + email);
    request.addEventListener("load", (event) => {
        let works = JSON.parse(event.target.responseText);
        console.log(works);
        if(works.length != 0) { 
            works.forEach((element) => {
                console.log(element['content']);
                addWorkForm(element['content']);
            });
        } else {
            alert('取得できる内容がありません');
        }
    });
    request.send();
}