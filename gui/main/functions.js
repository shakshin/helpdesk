var user = {
    name: '-',
    id: 0
};
var app = {
    revision: null,
    notified: false
};

function getUserInfo() {
    console.log('requesting user information');
    Ext.Ajax.request({
        url: 'index.php?r=data/uinfo',
        method: 'GET',
        success: function(resp) {
            data = Ext.JSON.decode(resp.responseText);
            user.name = data.name;
            user.id = data.id;
            Ext.getCmp('title').setTitle('Helpdesk ('+user.name+'). Сборка приложения: '+app.revision);
            if ((user.id ==1) ||(user.id == 2)) {
                Ext.getCmp('admin').show();
            }
        }
    });
}

function getAppInfo() {
    console.log('requesting application information');
    Ext.Ajax.request({
        url: 'index.php?r=data/appinfo',
        method: 'GET',
        success: function(resp) {
            data = Ext.JSON.decode(resp.responseText);
            app.revision = data.revision;
            Ext.getCmp('title').setTitle('Helpdesk ('+user.name+'). Сборка приложения: '+app.revision);
        }
    });
}

function checkUpdates() {
    Ext.Ajax.request({
        url: 'index.php?r=data/version',
        method: 'GET',
        success: function(resp) {
            if ((resp.responseText != app.revision) && (app.revision != null)) {
                if (app.notified == 0) {
                    console.log('new version of application detected. need reload');
                    Ext.MessageBox.alert('Обновление приложения!', 'Приложение на сервере обновилось. Обновите страницу для применения изменений.');
                    Ext.getCmp('title').setTitle('Helpdesk ('+user.name+'). Сборка приложения: '+app.revision + ' (<a href="javascript:window.location.reload()">обновить</a>)');
                    app.notified = 1;
                }
            }
        }
    });
}

function setRTFilter(id, text) {
    if (id != -1) {
        defRTid = id;
    } else {
        defRTid = null
    }
    if (id != -1) {
        defRTname = text;
    } else {
        defRTname = 'ВЫБЕРИТЕ ТИП ЗАЯВКИ!!!';
    }
    Ext.Ajax.request({
        url: 'index.php?r=data/setrtfilter',
        method: 'POST',
        params: {
            id: id
        },
        success: function() {
            console.log('selected new rtype filter');
            Ext.ComponentManager.get('rqPanel').setTitle('Заявки ('+text+')');
            gridsRefresh();
        },
        failure: function() {
            console.log('error while setting rtype filter');
            Ext.MessageBox.alert('Ошибка!', 'Не удалось установить фильтр!');
        }
    });    
}

function appInit() {
    console.log('application init');
    createFace();
    
    Ext.TaskManager.start({
        run: function() {
            gridsRefresh();
            checkUpdates();
        },
        interval: 30000
    });
    
    getUserInfo();
    getAppInfo();
    
    document.getElementById('preloader').style.display = "none";
    setRTFilter(-1, 'Все заявки');

    Ext.Ajax.request({
        url: 'index.php?r=request/setfilter',
        method: 'POST',
        params: {
            worker: null,
            date: 1
        },
        success: function() {Ext.getStore('complete').load()}
    });
}
