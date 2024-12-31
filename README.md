CodeIgniter 4 Framework

CodeIgniter Nedir?
CodeIgniter, hafif, hızlı, esnek ve güvenli bir PHP tam yığın web framework’üdür. Daha fazla bilgi için resmi web sitesini ziyaret edebilirsiniz.

Bu dokümanı, ekibimizle birlikte CodeIgniter 4 framework’ü üzerine çalışırken hazırladık. Framework'ün temellerini öğrenip projelerimizde nasıl daha verimli kullanabileceğimizi araştırdık.


---

index.php Dosyasındaki Önemli Değişiklik

CodeIgniter 4’te, index.php dosyası artık projenin kök dizininde yer almıyor. Daha iyi güvenlik ve bileşen ayrımı sağlamak için bu dosya public klasörüne taşınmıştır.

Bu değişikliği öğrendikten sonra, geliştirme sırasında web sunucumuzu public klasörüne yönlendirdik. Böylece uygulama güvenliğini artırıp framework dosyalarının dışarıdan erişilebilir olmasını engelledik.


---

Sunucu Gereksinimleri

CodeIgniter 4’ü çalıştırabilmek için PHP 7.4 veya üzeri bir sürüm gerekiyor. Ayrıca aşağıdaki eklentilerin yüklü olması şart:

intl

mbstring


Bunların yanı sıra, şu eklentilerin de aktif olduğundan emin olduk:

json (varsayılan olarak açık)

mysqlnd (MySQL kullanacaksanız)

libcurl (HTTP\CURLRequest kütüphanesi için)


Sunucu gereksinimlerini kontrol ettikten sonra, geliştirme ortamımızı eksiksiz bir şekilde kurduk ve framework ile çalışmaya başladık.


---

Katkılarımız

Ekibimizle birlikte çalışarak, CodeIgniter 4’ün temel özelliklerini inceledik ve projelerimiz için uygun yapıyı tasarladık. Ayrıca framework'ün esnekliği sayesinde, ihtiyaçlarımıza özel çözümler ürettik.

Bu süreçte, kullanıcı kılavuzunu ve topluluk forumlarını aktif bir şekilde takip ettik. Böylece framework'ün sunduğu olanakları daha iyi anladık ve projelerimizi daha sağlam bir temel üzerine inşa ettik.


---

Bu doküman, ekibimizin CodeIgniter 4’ü öğrenme ve uygulama sürecinde elde ettiği bilgileri paylaşmak amacıyla hazırlanmıştır. Framework’ün esnekliği ve güvenliği sayesinde, projelerimizde daha profesyonel sonuçlar elde etmeyi başardık.

