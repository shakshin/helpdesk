function showRequestDetails(rqId) {
    console.log('getting request information');
    Ext.Ajax.request({
        url: 'index.php?r=request/details',
        method: 'POST',
        params: {
            id: rqId
        },
        success: function(response) {
            console.log('data received');
            var rqDialog;
            var data = Ext.JSON.decode(response.responseText);
            rqDialog = Ext.create('Ext.window.Window', {
            title: 'Заявка №'+rqId,
            width: 800,
            height: 600,
            layout: 'border',
            items: [
                {
                    region: 'west',
                    collapsible: true,
                    collapsed: true,
                    resizable: true,
                    title: 'Сменить тип заявки',
                    layout: 'fit',
                    width: 200,
                    items: [
                            new Ext.tree.TreePanel({
                                store: new Ext.create("Ext.data.TreeStore", {
                                    root: {
                                        expanded: true
                                    },
                                    proxy: {
                                        type: 'ajax',
                                        url: 'index.php?r=data/rtypes'
                                    },
                                    autoLoad: true
                                }),
                                rootVisible: false,
                                listeners: {
                                    itemclick: {
                                        fn: function(y,r) {
                                            console.log('new request type selected');
                                            Ext.ComponentManager.get('rtypeId').setValue(r.data.id);
                                            Ext.ComponentManager.get('rtypeText').setValue(r.data.text);
                                        }
                                    }
                                }
                            })
                    ]
                },
                {
                    region: 'center',
                    layout: 'fit',
                    items: [
                        new Ext.create('Ext.form.Panel', {
                            url: 'index.php?r=request/save',
                            method: 'POST',
                            frame: true,
                            autoScroll: true,
                            bodyStyle:'padding:5px 5px 0',
                            fieldDefaults: {
                                msgTarget: 'side',
                                labelWidth: 100
                            },
                            defaultType: 'textfield',
                            defaults: {
                                anchor: '100%'
                            },
                            items: [
                                {
                                    xtype: 'hiddenfield',
                                    name: 'id',
                                    value: rqId
                                },
                                {
                                    xtype: 'hiddenfield',
                                    name: 'type_request_id',
                                    id: 'rtypeId',
                                    value: data.rtype_id
                                },
                                {
                                    xtype: 'displayfield',
                                    fieldLabel: 'Тип заявки',
                                    id: 'rtypeText',
                                    value: data.rtype
                                },
                                {
                                    xtype: 'fieldset',
                                    title: 'Пользователь: ' + data.fio,
                                    columnWidth: 1,
                                    collapsible: true,
                                    collapsed: true,
                                    defaultType: 'textfield',
                                    defaults: {anchor: '100%'},
                                    layout: 'anchor',
                                    items:[
                                        {
                                            name: 'fio',
                                            fieldLabel: 'ФИО',
                                            value: data.fio
                                        },
                                        {
                                            name: 'position',
                                            fieldLabel: 'Должность',
                                            value: data.position
                                        },
                                        {
                                            name: 'department',
                                            fieldLabel: 'Подразделение',
                                            value: data.department
                                        },
                                        {
                                            name: 'phone',
                                            fieldLabel: 'Телефон',
                                            value: data.phone
                                        },
                                        {
                                            name: 'pc',
                                            fieldLabel: 'Компьютер',
                                            value: data.pc
                                        }
                                    ]
                                },
                                {
                                    xtype: 'textareafield',
                                    name: 'description',
                                    fieldLabel: 'Описание проблемы',
                                    value: data.description
                                },
                                {
                                    xtype: 'textareafield',
                                    hidden: !data.isWorker,
                                    name: 'comment',
                                    fieldLabel: 'Мой комментарий',
                                    value: data.comment
                                },
                                {
                                    xtype: 'fieldset',
                                    title: 'Все комментарии',
                                    columnWidth: 1,
                                    collapsible: true,
                                    collapsed: true,
                                    defaultType: 'textfield',
                                    defaults: {anchor: '100%'},
                                    html: data.comments
                                },
                                {
                                    xtype: 'fieldset',
                                    title: 'Назначенные сотрудники',
                                    columnWidth: 1,
                                    collapsible: true,
                                    collapsed: true,
                                    defaultType: 'textfield',
                                    defaults: {anchor: '100%'},
                                    layout: 'anchor',
                                    items: [
                                        new Ext.create('Ext.grid.Panel', {
                                            height: 100,
                                            scroll: false,
                                            viewConfig: {
                                                style: {overflow: 'auto', overflowX: 'hidden'},
                                                stripeRows: true
                                            },
                                            forceFit: true,
                                            store: new Ext.create('Ext.data.JsonStore', {
                                                storeId: 'wlist',
                                                proxy: {
                                                    type: 'ajax',
                                                    url: 'index.php?r=request/workers&id='+rqId,
                                                    reader: {
                                                        type: 'json',
                                                        root: 'items',
                                                        totalProperty: 'totalCount'
                                                    }
                                                },
                                                idIndex: 0,
                                                autoLoad: true,
                                                fields: [
                                                    'id', 'name', 'status', 'date_begin', 'date_end'
                                                ]
                                            }),
                                            columns: [
                                                {
                                                    text: 'Сотрудник',
                                                    dataIndex: 'name',
                                                    width: 200
                                                },
                                                {
                                                    text: 'Статус',
                                                    dataIndex: 'status',
                                                    width: 100
                                                },
                                                {
                                                    text: 'Взята',
                                                    dataIndex: 'date_begin',
                                                    width: 200
                                                },
                                                {
                                                    text: 'Выполнена',
                                                    dataIndex: 'date_end',
                                                    width: 200
                                                }
                                            ]
                                        }),
                                        new Ext.create('Ext.form.ComboBox', {
                                            editable: false,
                                            hidden: !(data.alFull && !data.isClosed),
                                            fieldLabel: 'Назначить',
                                            store: new Ext.create('Ext.data.JsonStore', {
                                                storeId: 'usstore',
                                                proxy: {
                                                    type: 'ajax',
                                                    url: 'index.php?r=data/users',
                                                    reader: {
                                                        type: 'json',
                                                        root: 'items',
                                                        totalProperty: 'totalCount'
                                                    }                                                    
                                                },
                                                idIndex: 0,
                                                autoload: true,
                                                fields: [
                                                    'id', 'name'
                                                ]
                                            }),
                                            valueField: 'id',
                                            displayField: 'name',
                                            listeners: {
                                                select: function(cb, r) {
                                                    Ext.Ajax.request({
                                                        url: 'index.php?r=request/applyworker',
                                                        method: 'POST',
                                                        params: {
                                                            request: rqId,
                                                            worker: r[0].data.id
                                                        },
                                                        success: function () {
                                                            console.log('new worker applied');
                                                            Ext.data.StoreManager.get('wlist').load();
                                                            Ext.data.StoreManager.get('wkstore').load();
                                                        }
                                                    });
                                                    cb.clearValue();
                                                }
                                            }
                                        }),
                                        new Ext.create('Ext.form.ComboBox', {
                                            editable: false,
                                            hidden: !(data.alFull && !data.isClosed),
                                            fieldLabel: 'Убрать',
                                            store: new Ext.create('Ext.data.JsonStore', {
                                                storeId: 'wkstore',
                                                proxy: {
                                                    type: 'ajax',
                                                    url: 'index.php?r=request/workers&id='+rqId,
                                                    reader: {
                                                        type: 'json',
                                                        root: 'items',
                                                        totalProperty: 'totalCount'
                                                    }                                                    
                                                },
                                                idIndex: 0,
                                                autoload: true,
                                                fields: [
                                                    'id', 'name'
                                                ]
                                            }),
                                            valueField: 'id',
                                            displayField: 'name',
                                            listeners: {
                                                select: function(cb, r) {
                                                    Ext.Ajax.request({
                                                        url: 'index.php?r=request/deleteworker',
                                                        method: 'POST',
                                                        params: {
                                                            request: rqId,
                                                            worker: r[0].data.id
                                                        },
                                                        success: function () {
                                                            console.log('one of workers deleted');
                                                            Ext.data.StoreManager.get('wkstore').load();
                                                            Ext.data.StoreManager.get('wlist').load();
                                                        }
                                                    });
                                                    cb.clearValue();
                                                }
                                            }
                                        })
                                    ]
                                },
                                {
                                    xtype: 'fieldset',
                                    title: 'Срок исполнения',
                                    columnWidth: 1,
                                    collapsible: true,
                                    collapsed: true,
                                    defaultType: 'textfield',
                                    defaults: {anchor: '100%'},
                                    layout: 'anchor',
                                    items: [
                                        {
                                            xtype: 'datefield',
                                            fieldLabel: 'По плану',
                                            name: 'date_plan',
                                            value: data.date_plan,
                                            format: 'Y-m-d',
                                            readOnly: !data.alFull
                                        },
                                        {
                                            xtype: 'displayfield',
                                            fieldLabel: 'Фактически',
                                            value: data.date_end
                                        }
                                    ]
                                },
                                {
                                    xtype: 'fieldset',
                                    title: 'Дополнительная информация о заявке',
                                    columnWidth: 1,
                                    collapsible: true,
                                    collapsed: true,
                                    defaultType: 'textfield',
                                    defaults: {anchor: '100%'},
                                    layout: 'anchor',
                                    items:[
                                        {
                                            xtype: 'displayfield',
                                            fieldLabel: 'IP-адрес',
                                            value: data.ip
                                        },
                                        {
                                            xtype: 'displayfield',
                                            fieldLabel: 'Обновлено:',
                                            value: data.utime
                                        },
                                        {
                                            xtype: 'displayfield',
                                            fieldLabel: 'Автор правки:',
                                            value: data.uuser
                                        }
                                    ]
                                }
                            ],
                            buttons: [
                                {
                                    text: 'Сохранить изменения',
                                    hidden: data.isClosed,
                                    handler:  function() {
                                        this.up("form").getForm().submit({
                                            success: function() {
                                                console.log('request saved');
                                                Ext.MessageBox.alert('Заявка №'+rqId, 'Изменения сохранены');
                                                rqDialog.hide();
                                                gridsRefresh();
                                            },
                                            failure: function() {
                                                console.log('error while saving request');
                                                Ext.MessageBox.alert('Ошибка!', 'Не удалось сохранить изменения!');
                                            }
                                        });
                                    }
                                },
                                {
                                    text: 'Взять в работу',
                                    hidden: !(data.alWork && !data.isWorker && !data.isClosed),
                                    handler: function() {
                                        Ext.Ajax.request({
                                            url: 'index.php?r=request/take',
                                            method: 'POST',
                                            params: {id: rqId},
                                            success: function() {
                                                console.log('user has taken request');
                                                rqDialog.hide();
                                                gridsRefresh();
                                            },
                                            faliure: function() {
                                                console.log('error while taking request');
                                                Ext.MessageBox.alert('Ошибка!', 'Не удалось выполнить операцию!');
                                            }
                                        });
                                    }
                                },
                                {
                                    text: 'Выполнена',
                                    hidden: !data.isWorker,
                                    handler: function() {
                                        this.up("form").getForm().submit({
                                            success: function() {
                                                Ext.Ajax.request({
                                                    url: 'index.php?r=request/close',
                                                    method: 'POST',
                                                    params: {id: rqId},
                                                    success: function() {
                                                        console.log('request saved and closed');
                                                        rqDialog.hide();
                                                        Ext.MessageBox.alert('Заявка №'+rqId, 'Изменения сохранены');
                                                        gridsRefresh();
                                                    },
                                                    faliure: function() {
                                                        console.log('error while closing request');
                                                        Ext.MessageBox.alert('Ошибка!', 'Не удалось выполнить операцию!');
                                                    }
                                                })
                                            },
                                            failure: function() {
                                                console.log('error while saving request');
                                                Ext.MessageBox.alert('Ошибка!', 'Не удалось сохранить изменения!');
                                            }
                                        });
                                        
                                    }
                                },
                                {
                                    text: 'Вернуть в очередь',
                                    hidden: !data.isWorker,
                                    handler: function() {
                                        Ext.Ajax.request({
                                            url: 'index.php?r=request/release',
                                            method: 'POST',
                                            params: {id: rqId},
                                            success: function() {
                                                console.log('request released');
                                                rqDialog.hide();
                                                gridsRefresh();
                                            },
                                            faliure: function() {
                                                console.log('error while releasing request');
                                                Ext.MessageBox.alert('Ошибка!', 'Не удалось выполнить операцию!');
                                            }
                                        })
                                    }
                                },
                                {
                                    text: 'Напомнить исполнителям',
                                    hidden: !((data.isWorker || data.alFull) && !data.isClosed),
                                    handler: function() {
                                        Ext.Ajax.request({
                                            url: 'index.php?r=request/forcework',
                                            method: 'POST',
                                            params: {id: rqId},
                                            success: function() {
                                                console.log('notifications sent');
                                                rqDialog.hide();
                                                gridsRefresh();
                                            },
                                            faliure: function() {
                                                console.log('error while sending notifications');
                                                Ext.MessageBox.alert('Ошибка!', 'Не удалось выполнить операцию!');
                                            }
                                        })
                                    }
                                },
                                {
                                    text: 'Клонировать',
                                    handler: function() {
                                        rqDialog.hide();
                                        Ext.Ajax.request({
                                            url: 'index.php?r=request/details',
                                            method: 'POST',
                                            params: {
                                                id: rqId
                                            },
                                            success: function(response) {
                                                console.log('request data loaded into new request creation form');
                                                newRequest();
                                                var data = Ext.JSON.decode(response.responseText);
                                                Ext.ComponentManager.get('rtypeId').setValue(data.rtype_id);
                                                Ext.ComponentManager.get('rtypeText').setValue(data.rtype);
                                                Ext.ComponentManager.get('department').setRawValue(data.department);
                                                Ext.ComponentManager.get('position').setRawValue(data.position);
                                                Ext.ComponentManager.get('fio').setRawValue(data.fio);
                                                Ext.ComponentManager.get('phone').setValue(data.phone);
                                                Ext.ComponentManager.get('pc').setValue(data.pc);
                                                Ext.ComponentManager.get('description').setValue(data.description);
                                                Ext.Ajax.request({
                                                    url: 'index.php?r=data/canwork',
                                                    method: 'POST',
                                                    params: {'rtype': data.rtype_id },
                                                    success: function(result, request) {
                                                        if (result.responseText == 'true') {
                                                            console.log('user has rights to work on this request type');
                                                            Ext.ComponentManager.get('getWorkBtn').show();
                                                        } else {
                                                            console.log('user has not rights to work on this request type');
                                                            Ext.ComponentManager.get('getWorkBtn').hide();
                                                        }
                                                    }

                                                });
                                            },
                                            failure: function() {
                                                console.log('error while loading request data');
                                                Ext.MessageBox.alert('Ошибка!', 'Не удалось загрузить данные заявки!');
                                            }
                                        });
                                        
                                    }
                                }
                                
                            ]
                        })
                    ]
                }
            ],
            modal: true,
            resizable: false
        }).show();
        },
        failure: function() {
            console.log('error while loading request data');
            Ext.MessageBox.alert('Ошибка', 'Не удалось загрузить заявку!');
        }
    });    
}