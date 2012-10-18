var defRTid = null;
var defRTname = 'ВЫБЕРИТЕ ТИП ЗАЯВКИ!!!';

function newRequest() {    
    console.log('new request creation dialog');
    var newDialog = Ext.create('Ext.window.Window', {
        title: 'Новая заявка',
        modal: true,
        width: 800,
        height: 400,
        layout: 'border',
        items: [
            {
                region: 'west',
                layout: 'fit',
                width: 400,
                collapsible: true,
                collapsed: true,
                title: 'Выберите тип заявки',
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
                                    console.log('rtype selected');
                                    Ext.ComponentManager.get('rtypeId').setValue(r.data.id);
                                    Ext.ComponentManager.get('rtypeText').setValue(r.data.text);
                                    Ext.Ajax.request({
                                        url: 'index.php?r=data/canwork',
                                        method: 'POST',
                                        params: {'rtype': r.data.id },
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
                        url: 'index.php?r=request/create',
                        method: 'POST',
                        frame: true,
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
                                id: 'rtypeId',
                                xtype: 'hiddenfield',
                                name: 'rtype',
                                value: defRTid
                            },
                            {
                                id: 'rtypeText',
                                xtype: 'displayfield',
                                fieldLabel: 'Тип заявки',
                                value: defRTname
                            },
                            {
                                xtype: 'hiddenfield',
                                name: 'worker',
                                itemId: 'worker'
                            },
                            {
                                id: 'fio',
                                itemId: 'fio',
                                name: 'fio',
                                fieldLabel: 'ФИО'
                            },
                            {
                                id: 'position',
                                itemId: 'position',
                                name: 'position',
                                fieldLabel: 'Должность'
                            },
                            {
                                id: 'department',
                                itemId: 'depertment',
                                name: 'department',
                                fieldLabel: 'Подразделение'
                            },
                       /*     new Ext.create('Ext.form.ComboBox',{
                                selectOnTab: false,
                                fieldLabel: 'ФИО',
                                name: 'fio',
                                id: 'fio',
                                hideTrigger: true,
                                displayField: 'fio',
                                valueField: 'fio',
                                typeAhead: true,
                                allowBlank: false,
                                store: new Ext.create('Ext.data.JsonStore', {
                                    fields: ['fio'],
                                    proxy: {
                                        type: 'ajax',
                                        url: 'index.php?r=data/fio',
                                        autoLoad: true
                                    }
                                }),
                                listeners: {
                                    select: function(me) {
                                        Ext.Ajax.request({
                                            url: 'index.php?r=data/udata',
                                            params: {fio: me.getValue()},
                                            success: function (response) {
                                                console.log('found matches for selected employee');
                                                var res = Ext.JSON.decode(response.responseText);
                                                Ext.getCmp('phone').setValue(res.phone);
                                                Ext.getCmp('pc').setValue(res.pc);
                                                Ext.getCmp('department').setRawValue(res.department);
                                                Ext.getCmp('position').setRawValue(res.position);
                                            }
                                        });
                                    }
                                }
                            }), */
                            {
                                xtype: 'textfield',
                                fieldLabel: 'Телефон',
                                name: 'phone',
                                id: 'phone',
                                allowBlank: false
                            },
                            {
                                xtype: 'textfield',
                                fieldLabel: 'Имя компьютера',
                                name: 'pc',
                                id: 'pc',
                                allowBlank: false
                            },
                            {
                                xtype: 'textareafield',
                                fieldLabel: 'Описание проблемы',
                                id: 'description',
                                name: 'description',
                                allowBlank: false
                            },
                            {
                                xtype: 'displayfield',
                                value: 'Нечем заполнить поле? Поставьте прочерк!'
                            }
                        ],
                        buttons: [
                            {
                                text: 'Создать',
                                handler: function() {
                                    if (this.up('form').getForm().isValid()) {
                                        this.up('form').getForm().submit({
                                            success: function() {
                                                console.log('request saved');
                                                newDialog.hide();
                                                gridsRefresh();
                                            },
                                            failure: function() {
                                                console.log('error while submitting form');
                                                Ext.MessageBox.alert('Ошибка', 'Не удалось сохранить заявку!');
                                            }
                                        });
                                    }

                                }
                            },
                            {
                                text: 'Создать и взять в работу',
                                id: 'getWorkBtn',
                                hidden: true,
                                handler: function() {
                                    this.up('form').down('#worker').setValue(user.id);
                                    if (this.up('form').getForm().isValid()) {
                                        this.up('form').getForm().submit({
                                            success: function() {
                                                console.log('request saved');
                                                newDialog.hide();
                                                gridsRefresh();
                                            },
                                            failure: function() {
                                                console.log('error while submitting form');
                                                Ext.MessageBox.alert('Ошибка', 'Не удалось сохранить заявку!');
                                            }
                                        });
                                    }

                                }
                            }
                        ]
                    })
                ]
            }
        ]
    });
    newDialog.show();
    
    $("#fio > div > input").autocomplete({url: 'index.php?r=suggest/fio', minChars: 3,
        onItemSelect: function(item) {
            Ext.Ajax.request({
                url: 'index.php?r=data/udata',
                params: {fio: item.value},
                success: function (response) {
                    console.log('found matches for selected employee');
                    var res = Ext.JSON.decode(response.responseText);
                    Ext.getCmp('phone').setValue(res.phone);
                    Ext.getCmp('pc').setValue(res.pc);
                    Ext.getCmp('department').setValue(res.department);
                    Ext.getCmp('position').setValue(res.position);
                }
            });
        }
    });
    $("#position > div > input").autocomplete({url: 'index.php?r=suggest/position', minChars: 3});
    $("#department > div > input").autocomplete({url: 'index.php?r=suggest/department', minChars: 3});
    
    if (defRTid != null) {
        Ext.Ajax.request({
            url: 'index.php?r=data/canwork',
            method: 'POST',
            params: {'rtype': defRTid },
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
    }
}