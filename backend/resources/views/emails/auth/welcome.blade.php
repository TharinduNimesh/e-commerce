<x-mail::message>
# 🌟 Welcome to eShop! 🌟

Dear {{ $data['name'] }},
<br><br>
Step into a world of endless possibilities, where your shopping experience is our top priority. We are thrilled to welcome you to eShop, your go-to destination for all things fabulous and convenient.
<br><br>
At eShop, we believe in making your shopping journey delightful and hassle-free. Whether you're on the hunt for the latest fashion trends, cutting-edge electronics, or unique home decor, we've got it all. Our extensive collection is curated to cater to your diverse tastes and preferences.
<br>
@php $url = env('FRONTEND_URL') @endphp
<x-mail::button :url="$url">
Start Shopping
</x-mail::button>

Thank you for choosing eShop! We're here to make your online shopping experience extraordinary. Feel free to reach out to our dedicated customer support team if you have any questions or need assistance.

Happy shopping!

Best regards, <br>
The eShop Team
</x-mail::message>
