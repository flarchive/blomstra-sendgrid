import app from 'flarum/common/app';

app.initializers.add('blomstra/flarum-sendgrid', () => {
  console.log('[blomstra/flarum-sendgrid] Hello, forum and admin!');
});
