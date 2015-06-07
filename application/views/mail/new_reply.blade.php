<div class="wrap" style="direction: rtl; font-family: tahoma;font-size: 12px;text-align: right;">
<p>
	سلام {{ $user->name }}
</p>
<p>
برای مبحث " {{ $post->discussion->title }} " پاسخ جدیدی توسط {{ $post->author->name }} ارسال شده است.
لطفاً برای دیدن پاسخ به آدرس زیر بروید.
</p>
<p>
<span>آدرس : <a href="{{ URL::to_route('view_discussion', $post->disc_id) }}">{{ URL::to_route('view_discussion', $post->disc_id) }}</a></span><br />
<p>

<div>با آرزوی موفقیت.</div>

</div>