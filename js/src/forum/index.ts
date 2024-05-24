import app from 'flarum/forum/app';

app.initializers.add('blomstra/flarum-sendgrid', () => {
  console.log('[blomstra/flarum-sendgrid] Hello, forum!');
});
