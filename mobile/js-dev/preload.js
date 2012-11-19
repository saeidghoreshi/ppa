preload = new Array(
   'assets/keypad/key_1.png',
   'assets/keypad/key_2.png',
   'assets/keypad/key_3.png',
   'assets/keypad/key_no.png',
   'assets/keypad/key_4.png',
   'assets/keypad/key_5.png',
   'assets/keypad/key_6.png',
   'assets/keypad/key_cancel.png',
   'assets/keypad/key_7.png',
   'assets/keypad/key_8.png',
   'assets/keypad/key_9.png',
   'assets/keypad/key_ok.png',
   'assets/keypad/key_corr.png',
   'assets/keypad/key_dot.png',
   'assets/keypad/key_0.png',
   'assets/keypad/button-bg-active.png',
   'assets/keypad/account-button-bg-active.png',
   'assets/keypad/info-button.png',
   'assets/keypad/bg_r.png',
   'assets/keypad/account-button-bg_r.png',
   'assets/keypad/key_1_r.png',
   'assets/keypad/key_2_r.png',
   'assets/keypad/key_3_r.png',
   'assets/keypad/key_no_r.png',
   'assets/keypad/key_4_r.png',
   'assets/keypad/key_5_r.png',
   'assets/keypad/key_6_r.png',
   'assets/keypad/key_cancel_r.png',
   'assets/keypad/key_7_r.png',
   'assets/keypad/key_8_r.png',
   'assets/keypad/key_9_r.png',
   'assets/keypad/key_ok_r.png',
   'assets/keypad/key_corr_r.png',
   'assets/keypad/key_dot_r.png',
   'assets/keypad/key_0_r.png',
   'assets/keypad/account-button-bg.png',
   'assets/keypad/lcd_r.png',
   'assets/keypad/bg.png'
);
for (i=0; i < preload.length; i++){
   prefetch_link_tag = document.createElement('link');
   prefetch_link_tag.setAttribute('rel', 'prefetch prerender');
   prefetch_link_tag.setAttribute('href', preload[i]);
   document.querySelector('head').appendChild(prefetch_link_tag);
}