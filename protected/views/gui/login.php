<script>
Ext.require([
    'Ext.form.*',
    'Ext.layout.container.Column',
    'Ext.tab.Panel',
    'Ext.window.MessageBox'
]);

Ext.onReady(function(){

    Ext.QuickTips.init();

    var bd = Ext.getBody();

    var form = Ext.create('Ext.form.Panel', {
        url:'index.php?r=logon',
        frame:true,
        bodyStyle:'padding:5px 5px 0',
        width: 400,
		name: 'login-form',
		id: 'login-form',
        fieldDefaults: {
            msgTarget: 'side',
            labelWidth: 75
        },
        defaultType: 'textfield',
        defaults: {
            anchor: '100%'
        },

        items: [{
            fieldLabel: 'Пользователь',
            name: 'username',
            allowBlank:false,
            labelWidth: 110
        },{
            fieldLabel: 'Пароль',
            name: 'password',
            inputType: 'password',
            labelWidth: 110
        },{
            fieldLabel: 'Новый пароль',
            name: 'newpassword',
			id: 'newpassword',
            inputType: 'password',
			hidden: true,
			disabled: true,
			allowBlank:false,
            labelWidth: 110
        },{
            fieldLabel: 'Повторите пароль',
            name: 'newpassword1',
			id: 'newpassword1',
            inputType: 'password',
			hidden: true,
			disabled: true,
			allowBlank:false,
            labelWidth: 110
        }],

        buttons: [{
            text: 'Вход',
			name: 'button',
			id: 'button',
            listeners: { click: function(btn) {
                if (this.up("form").getForm().isValid()) {
					// необходимо проверить, что пароли совпадают
					if (this.up("form").getForm().findField('newpassword').isVisible()) {
						if (this.up("form").getForm().findField('newpassword').getValue() !== this.up("form").getForm().findField('newpassword1').getValue()) {
							Ext.MessageBox.alert('Ошибка','Введенные пароли не совпадают!');
							this.up("form").getForm().findField('newpassword').reset();
							this.up("form").getForm().findField('newpassword1').reset();
							return;
						}
					}
					this.up("form").getForm().submit(
                        {
                            success: function() {
                                document.location  = 'index.php?r=gui';                                
                            },
                            failure: function(frm, act) {
								if (Ext.isEmpty(act.result.errors)) {
									Ext.MessageBox.alert('Ошибка','Неверное имя или пароль!');
							/*
							 * обратно прячем при необходимости все поля
							 */
									btn.setText('Вход');
									if (frm.findField('newpassword').isVisible()) {
										frm.findField('newpassword').setVisible(false);
										frm.findField('newpassword').disable(true);
										frm.findField('newpassword1').setVisible(false);
										frm.findField('newpassword1').disable(true);
									}
									var login = frm.findField('username').getValue();
									frm.reset();
									frm.findField('username').setValue(login);
								}
								else if ( act.result.errors.change == '1') {
									Ext.MessageBox.alert('Внимание', 'Вам необходимо сменить пароль');
									frm.findField('newpassword').setVisible(true);
									frm.findField('newpassword').enable(true);
									frm.findField('newpassword1').setVisible(true);
									frm.findField('newpassword1').enable(true);
									btn.setText('Сменить пароль');
								}
								else if ( act.result.errors.change == '2') {
									Ext.MessageBox.alert('Ошибка', 'Ошибка при смене пароля, повторите');
								}
								else {
									Ext.MessageBox.alert('Ошибка','Неверный параметр в ответе!');
									frm.reset();									
								}
                            }
                        }
					);
                }
            }}
        }]
    });
	var KeyMap = new Ext.KeyMap(document, {
				key: Ext.EventObject.ENTER,
				fn: function() {
						//Ext.MessageBox.alert(Ext.getCmp('button').getText(), '2');
						Ext.getCmp('button').fireEvent('click', Ext.getCmp('button'));
					},
					scope: this
				});

	win = Ext.widget('window', {
                title: 'Вход в систему',
                closable: false,
                minHeight: 160,
                layout: 'fit',
                resizable: false,
                modal: true,
                items: form
            });
    win.show();
});
   </script>
   