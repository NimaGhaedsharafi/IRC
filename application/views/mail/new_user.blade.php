<div class="wrap" style="direction: rtl; font-family: tahoma;font-size: 12px;text-align: right;">
<p>
	سلام {{ $name }}
</p>
<p>
شما در لیست کاربران کانال ارتباطی بازی ساتراپ قرار گرفته اید.
برای ورود به آدرس زیر مراجعه نمائید.
</p>
<p>
<span>آدرس : {{ URL::to_route('base') }}</span><br />
<span>نام کاربری : {{ $email }}</span> <br />
<span>رمز عبور : {{ $password }}</span><br />
<p>

<div>با آرزوی موفقیت.</div>

</div>