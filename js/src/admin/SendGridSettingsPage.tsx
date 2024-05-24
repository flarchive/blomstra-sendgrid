import ExtensionPage, { ExtensionPageAttrs } from 'flarum/admin/components/ExtensionPage';

export default class SendGridSettingsPage extends ExtensionPage {
  content() {
    return (
      <div className="SendGridSettingsPage">
        <div className="container">
          <form>
            <h2>{app.translator.trans('blomstra-sendgrid.admin.sendgrid.heading')}</h2>
            <div className="helpText">{app.translator.trans('blomstra-sendgrid.admin.sendgrid.text')}</div>

            <fieldset className="parent">
              {this.buildSettingComponent({
                setting: 'blomstra-sendgrid.sendgrid_suspend_when_email_bounced',
                label: app.translator.trans('blomstra-sendgrid.admin.sendgrid_suspend_when_email_bounced_label'),
                help: app.translator.trans('blomstra-sendgrid.admin.sendgrid_suspend_when_email_bounced_help'),
                type: 'boolean',
              })}

              {this.buildSettingComponent({
                setting: 'blomstra-sendgrid.sendgrid_disable_notifications_on_spam_report',
                label: app.translator.trans('blomstra-sendgrid.admin.sendgrid_disable_notifications_on_spam_report_label'),
                help: app.translator.trans('blomstra-sendgrid.admin.sendgrid_disable_notifications_on_spam_report_help'),
                type: 'boolean',
              })}
            </fieldset>

            {this.submitButton()}
          </form>
        </div>
      </div>
    );
  }
}
