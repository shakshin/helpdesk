function createFace() {
    Ext.create('Ext.container.Viewport', {
        id: 'app',
        layout: 'fit',
        items: {
            id: 'title',
            title: 'Helpdesk',
            tools: [
                {
                    type: 'close',
                    tooltip: 'выйти из системы',
                    handler: function() {
                        console.log('logout request');
                        document.location = "index.php?r=site/logout";
                    }
                }
            ],
            layout: 'border',
            defaults: {
                collapsible: true,
                split: true
            },
            items: [
                {
                    region: 'west',
                    width: 350,
                    title: 'Фильтр по типу заявок',
                    layout: 'fit',
                    items: getTree(),
                    collapsed: true,
                    tools: [
                        {
                            type: 'refresh',
                            tooltip: 'обновить дерево типов',
                            handler: function() {
                                console.log('reloading tree');
                                Ext.getStore('tree').load();
                            }
                        }
                    ]
                },
                {
                    region: 'center',
                    title: 'Заявки',
                    id: 'rqPanel',
                    collapsible: false,
                    xtype: 'tabpanel',
                    tools: [
                        {
                            type: 'refresh',
                            tooltip: 'Обновить списки заявок',
                            handler: function () {
                                gridsRefresh();
                            }
                        }
                    ],
                    items: [
                        {
                            title: 'Мои',
                            layout: 'fit',
                            items: getMyGrid()
                        },
                        {
                            title: 'Открытые',
                            layout: 'fit',
                            items: getOpenGrid()
                        },
                        {
                            title: 'В работе',
                            layout: 'fit',
                            items: getWorkGrid()
                        },
                        {
                            title: 'Выполненые',
                            layout: 'border',
                            items: [
                                {
                                    region: 'north',
                                    collapsible: false,
                                    resizable: false,
                                    height: 45,
                                    items: new Ext.create('Ext.form.Panel', {
                                        url: 'index.php?r=request/setfilter',
                                        method: 'POST',
                                        frame: true,
                                        bodyStyle:'padding:5px 5px 0',
                                        fieldDefaults: {
                                            msgTarget: 'side',
                                            labelWidth: 100
                                        },
                                        defaultType: 'textfield',
                                        layout: 'hbox',
                                        items: [
                                            new Ext.create('Ext.form.ComboBox', {
                                                id: 'filterWorker',
                                                editable: false,
                                                name: 'worker',
                                                fieldLabel: 'По сотруднику',
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
                                                displayField: 'name',
                                                valueField: 'id'
                                            }) ,
                                            {
                                                xtype: 'displayfield',
                                                width: 10
                                            },
                                            new Ext.create('Ext.form.ComboBox',{
                                                id: 'filterDate',
                                                editable: false,
                                                name: 'date',
                                                fieldLabel: 'По дате',
                                                store: new Ext.create('Ext.data.Store', {
                                                    fields: [
                                                        'id', 'text'
                                                    ],
                                                    data: [
                                                        {id: 1, text: 'За сегодня'},
                                                        {id: 2, text: 'За эту неделю'},
                                                        {id: 3, text: 'За этот месяц'},
                                                        {id: 4, text: 'За прошлый месяц'}
                                                    ]
                                                }),
                                                displayField: 'text',
                                                valueField: 'id',
                                                value: 1
                                            }),
                                            {
                                                xtype: 'displayfield',
                                                width: 10
                                            },
                                            new Ext.create('Ext.Button', {
                                                text: 'Применить',
                                                handler: function() {
                                                    this.up('form').getForm().submit({
                                                        success: function() {
                                                            console.log('selected filter for complete tab');
                                                            Ext.getStore('complete').load()
                                                        }
                                                    });
                                                }
                                            }),
                                            {
                                                xtype: 'displayfield',
                                                width: 10
                                            },
                                            new Ext.create('Ext.Button', {
                                                text: 'Сбросить',
                                                handler: function() {
                                                    Ext.ComponentManager.get('filterWorker').setRawValue('');
                                                    Ext.ComponentManager.get('filterDate').setValue(1);
                                                    this.up('form').getForm().submit({
                                                        success: function() {
                                                            console.log('filter reset');
                                                            Ext.getStore('complete').load()
                                                        }
                                                    });
                                                }
                                            }) 
                                        ]
                                    })                                    
                                },
                                {
                                    region: 'center',
                                    layout: 'fit',
                                    items: getCompleteGrid()
                                }
                            ]
                            
                        },
                        {
                            title: 'Сотрудники',
                            layout: 'fit',
                            items: getBusyGrid()
                        }
                    ]
                },
                {
                    region: 'south',
                    height: 45,
                    layout: 'hbox',
                    header: false,
                    items: [
                        new Ext.create('Ext.Button', {
                            margin: 5,
                            text: 'Новая заявка',
                            handler: function() {
                                newRequest();
                            }
                        }),
                        new Ext.create('Ext.Button', {
                            margin: 5,
                            text: 'Поиск по номеру',
                            handler: function() {
                                var searchDialog = Ext.create('Ext.window.Window', {
                                    title: 'Поиск по номеру',
                                    modal: true,
                                    width: 400,
                                    height: 50,
                                    layout: 'fit',
                                    items: new Ext.create('Ext.form.Panel', {
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
                                        layout: 'anchor',
                                        items: [
                                            {
                                                id: 'rqNumber',
                                                fieldLabel: 'Номер заявки'
                                            }
                                        ],
                                        buttons: [
                                            {
                                                text: 'Найти',
                                                handler : function() {
                                                    searchDialog.hide();
                                                    showRequestDetails(Ext.ComponentManager.get('rqNumber').getValue());
                                                }
                                            }
                                        ]
                                    })
                                });
                                searchDialog.show();
                            }
                        }),
                        new Ext.create('Ext.Button', {
                            id: 'report',
                            margin: 5,
                            text: 'Отчет',
                            handler: function() {
                                var reportDialog = Ext.create('Ext.window.Window', {
                                    title: 'Отчет за месяц',
                                    modal: true,
                                    width: 400,
                                    height: 50,
                                    layout: 'fit',
                                    items: new Ext.create('Ext.form.Panel', {
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
                                        layout: 'anchor',
                                        items: [
                                            new Ext.create('Ext.form.ComboBox', {
                                                fieldLabel: 'Месяц',
                                                id: 'rpMonth',
                                                name: 'month',
                                                displayField: 'name',
                                                valueField: 'month',
                                                store: new Ext.create('Ext.data.JsonStore', {
                                                    storeId: 'rmonth',
                                                    fields: ['month', 'name'],
                                                    proxy: {
                                                        type: 'ajax',
                                                        url: 'index.php?r=data/rmonth',
                                                        autoLoad: true,
                                                        reader: {
                                                            type: 'json',
                                                            root: 'items',
                                                            totalProperty: 'totalCount'
                                                        }
                                                    }
                                                })
                                            })
                                        ],
                                        buttons: [
                                            {
                                                text: 'Собрать отчет',
                                                handler: function() {
                                                    reportDialog.hide();
                                                    window.open('index.php?r=report&month='+Ext.getCmp('rpMonth').getValue(),'_blank');
                                                }
                                            }
                                        ]
                                    })
                                });
                                reportDialog.show();
                            }
                        }),
                        new Ext.create('Ext.Button', {
                            id: 'admin',
                            margin: 5,
                            text: 'Управление',
                            hidden: !((user.id == 2) || (user.id == 1)),
                            handler: function() {
                                window.open('index.php?r=gui/admin','_blank');
                            }
                        })
                    ]
                }
                
            ]
        }
    });
}
