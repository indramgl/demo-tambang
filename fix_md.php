<?php
$pages = ['home','history','vision-mission','services','contact','portfolio','investor'];
$locales = ['ID','EN','ZH','FR','ES','JA'];
$titles = [
    'home' => ['Beranda','Home','首页','Accueil','Inicio','ホーム'],
    'history' => ['Sejarah','History','历史','Histoire','Historia','歴史'],
    'vision-mission' => ['Visi & Misi','Vision & Mission','愿景与使命','Vision & Mission','Visión y Misión','ビジョンとミッション'],
    'services' => ['Layanan','Services','服务','Services','Servicios','サービス'],
    'contact' => ['Kontak','Contact','联系','Contacto','Contacto','お問い合わせ'],
    'portfolio' => ['Portofolio','Portfolio','作品集','Portefeuille','Portafolio','ポートフォリオ'],
    'investor' => ['Investor','Investor','投资者','Investisseur','Inversor','投資家'],
];
foreach ($pages as $page) {
    foreach ($locales as $locale) {
        $dir = "C:/Coding/perusahaan-tambang/app/Views/pages/$page/$locale";
        if (!is_dir($dir)) { mkdir($dir, 0755, true); }
        $idx = array_search($locale, $locales);
        $title = $titles[$page][$idx];
        $content = "# $title\n\nPlaceholder content for $page in $locale.\n";
        file_put_contents("$dir/page.md", $content);
    }
}
echo "DONE\n";
