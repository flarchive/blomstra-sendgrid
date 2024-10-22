import app from 'flarum/admin/app';
import SendGridSettingsPage from './SendGridSettingsPage';

app.initializers.add('blomstra/flarum-sendgrid', () => {
  app.extensionData.for('blomstra-sendgrid').registerPage(SendGridSettingsPage);
});
