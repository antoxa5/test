<?php
if(!function_exists('form_separate_review_single_new')) {
	function form_separate_review_single_new($post_id,$new_name = '') {
		$languages = get_locale();
		$languages_1 = [
			'en_US' => 'New company review',
			'fr_FR' => 'Nouvelle revue d\'entreprise',
			'de_DE' => 'Neue Unternehmensbewertung',
			'es_ES' => 'Revisión de la nueva empresa',
			'ru_RU' => 'Новый отзыв о компании',
			'pl_PL' => 'Nowa recenzja firmy',
			'fi' => 'Uusi yritysarviointi',
			'id_ID' => 'Ulasan perusahaan baru',
		];
		$languages_2 = [
			'en_US' => 'I want to write a review about another company',
			'fr_FR' => 'Je veux écrire une critique sur une autre entreprise',
			'de_DE' => 'Ich möchte eine Bewertung über ein anderes Unternehmen schreiben',
			'es_ES' => 'Quiero escribir una reseña sobre otra empresa',
			'ru_RU' => 'Я хочу написать отзыв о другой компании',
			'pl_PL' => 'Chcę napisać opinię o innej firmie',
			'fi' => 'Haluan kirjoittaa arvostelun toisesta yrityksestä',
			'id_ID' => 'Saya ingin menulis ulasan tentang perusahaan lain',
		];
		$languages_3 = [
			'en_US' => 'New Review',
			'fr_FR' => 'Nouvelle revue',
			'de_DE' => 'Neue Rezension',
			'es_ES' => 'Nueva revisión',
			'ru_RU' => 'Новый отзыв',
			'pl_PL' => 'Nowa recenzja',
			'fi' => 'Uusi arvostelu',
			'id_ID' => 'Ulasan Baru',
		];
		$languages_4 = [
			'en_US' => 'Fields marked with an asterisk * are required',
			'fr_FR' => 'Les champs marqués d\'un astérisque * sont obligatoires.',
			'de_DE' => 'Die mit einem Sternchen * gekennzeichneten Felder sind Pflichtfelder.',
			'es_ES' => 'Los campos marcados con un asterisco * son obligatorios',
			'ru_RU' => 'Поля, отмеченные звездочкой *, обязательны для заполнения',
			'pl_PL' => 'Pola oznaczone gwiazdką * są obowiązkowe',
			'fi' => 'Tähdellä * merkityt kentät ovat pakollisia.',
			'id_ID' => 'Kolom yang ditandai dengan tanda bintang * wajib diisi',
		];
		$languages_5 = [
			'en_US' => 'Need legal advice?',
			'fr_FR' => 'Avez-vous besoin d\'un conseil juridique ?',
			'de_DE' => 'Benötigen Sie eine Rechtsberatung?',
			'es_ES' => '¿Necesita asesoramiento jurídico?',
			'ru_RU' => 'Нужна консультация юриста?',
			'pl_PL' => 'Czy potrzebujesz porady prawnej?',
			'fi' => 'Tarvitsetko oikeudellista neuvontaa?',
			'id_ID' => 'Butuh nasihat hukum?',
		];
		$languages_6 = [
			'en_US' => 'Evaluate the company according to the following criteria',
			'fr_FR' => 'Évaluez l\'entreprise selon les critères suivants',
			'de_DE' => 'Bewerten Sie das Unternehmen nach folgenden Kriterien',
			'es_ES' => 'Evaluar la empresa según los siguientes criterios',
			'ru_RU' => 'Оцените компанию по критериям',
			'pl_PL' => 'Oceń firmę według następujących kryteriów',
			'fi' => 'Arvioi yritystä seuraavien kriteerien perusteella',
			'id_ID' => 'Mengevaluasi perusahaan berdasarkan kriteria berikut',
		];
		$languages_7 = [
			'en_US' => 'Ask a lawyer questions for free <a href=\'/visit/destralegal/\' target=\'_blank\'>here</a>.',
			'fr_FR' => 'Posez gratuitement des questions à un avocat <a href=\'/visit/destralegal/\' target=\'_blank\'>here</a>.',
			'de_DE' => 'Stellen Sie <a href=\'/visit/destralegal/\' target=\'_blank\'>hier</a> kostenlos Fragen an einen Anwalt.',
			'es_ES' => 'Haga preguntas gratuitas a un abogado <a href=\'/visit/destralegal/\' target=\'_blank\'>aquí</a>.',
			'ru_RU' => 'Задайте вопросы юристу бесплатно <a href=\'/visit/destralegal/\' target=\'_blank\'>здесь</a>.',
			'pl_PL' => 'Zadaj prawnikowi pytania za darmo <a href=\'/visit/destralegal/\' target=\'_blank\'>tutaj</a>.',
			'fi' => 'Kysy asianajajalta kysymyksiä ilmaiseksi <a href=\'/visit/destralegal/\' target=\'_blank\'>täällä</a>.',
			'id_ID' => 'Ajukan pertanyaan kepada pengacara secara gratis <a href=\'/visit/destralegal/\' target=\'_blank\'>di sini</a>.',
		];
		$languages_8 = [
			'en_US' => 'The company\'s evaluation is mandatory for the publication of a review.',
			'fr_FR' => 'L\'évaluation de l\'entreprise est obligatoire pour la publication d\'un examen.',
			'de_DE' => 'Die Bewertung des Unternehmens ist für die Veröffentlichung einer Rezension obligatorisch.',
			'es_ES' => 'La evaluación de la empresa es obligatoria para la publicación de una revisión.',
			'ru_RU' => 'Оценка компании является обязательной для публикации отзыва',
			'pl_PL' => 'Ocena firmy jest obowiązkowa do publikacji recenzji.',
			'fi' => 'Yrityksen arviointi on pakollinen edellytys katsauksen julkaisemiselle.',
			'id_ID' => 'Evaluasi perusahaan wajib dilakukan untuk publikasi tinjauan.',
		];
		$languages_9 = [
			'en_US' => 'Evaluate the company according to the criteria *',
			'fr_FR' => 'Notez l\'entreprise selon les critères *',
			'de_DE' => 'Bewerten Sie das Unternehmen nach den Kriterien *',
			'es_ES' => 'Califique a la empresa según los criterios *',
			'ru_RU' => 'Оцените компанию по критериям *',
			'pl_PL' => 'Oceń firmę według kryteriów *.',
			'fi' => 'Arvioi yritys kriteerien mukaan *',
			'id_ID' => 'Mengevaluasi perusahaan sesuai dengan kriteria *',
		];
		$languages_10 = [
			'en_US' => 'How long have you been using it?',
			'fr_FR' => 'Depuis combien de temps l\'utilisez-vous ?',
			'de_DE' => 'Wie lange benutzen Sie es schon?',
			'es_ES' => '¿Cuánto tiempo lleva usándolo?',
			'ru_RU' => 'Как давно пользовались?',
			'pl_PL' => 'Jak długo go używasz?',
			'fi' => 'Kuinka kauan olet käyttänyt sitä?',
			'id_ID' => 'Sudah berapa lama Anda menggunakannya?',
		];
		$languages_11 = [
			'en_US' => 'Would you recommend it to your friends?',
			'fr_FR' => 'Le recommanderiez-vous à vos amis ?',
			'de_DE' => 'Würden Sie es Ihren Freunden empfehlen?',
			'es_ES' => '¿Lo recomendarías a tus amigos?',
			'ru_RU' => 'Рекомендуете друзьям?',
			'pl_PL' => 'Czy poleciłbyś ją swoim znajomym?',
			'fi' => 'Suosittelisitko sitä ystävillesi?',
			'id_ID' => 'Apakah Anda akan merekomendasikannya kepada teman-teman Anda?',
		];
		$languages_12 = [
			'en_US' => 'Inaccurate',
			'fr_FR' => 'Invalide',
			'de_DE' => 'Ungültig',
			'es_ES' => 'Inválido',
			'ru_RU' => 'Недостоверный',
			'pl_PL' => 'Nieważne',
			'fi' => 'Virheellinen',
			'id_ID' => 'Tidak akurat',
		];
		$languages_13 = [
			'en_US' => 'Approved',
			'fr_FR' => 'Approuvé',
			'de_DE' => 'Genehmigt',
			'es_ES' => 'Aprobado',
			'ru_RU' => 'Одобрен',
			'pl_PL' => 'Zatwierdzone',
			'fi' => 'Hyväksytty',
			'id_ID' => 'Disetujui',
		];
		$languages_14 = [
			'en_US' => 'Your review does not contribute to the company\'s rating. To have it affect the company\'s rating and receive "Approved" status, add text of 150 characters or more.',
			'fr_FR' => 'Votre avis ne contribue pas à l\'évaluation de l\'entreprise. Ajouter un texte de 150 caractères ou plus pour être considéré comme "Approuvé".',
			'de_DE' => 'Ihre Bewertung trägt nicht zum Rating des Unternehmens bei. Fügen Sie einen Text von 150 Zeichen oder mehr hinzu, um als "genehmigt" zu gelten.',
			'es_ES' => 'Su opinión no contribuye a la calificación de la empresa. Añada un texto de 150 caracteres o más para que se considere "Aprobado".',
			'ru_RU' => 'Ваш отзыв не участвует в рейтинге компании. Чтобы он повлиял на рейтинг компании и получил статус «Одобрен», добавьте текст от 150 символов.',
			'pl_PL' => 'Twoja recenzja nie przyczynia się do oceny firmy. Dodaj tekst o długości 150 znaków lub więcej, aby uznać go za "Zatwierdzony".',
			'fi' => 'Arvostelusi ei vaikuta yrityksen luokitukseen. Lisää vähintään 150 merkkiä pitkä teksti, jotta se katsotaan "Hyväksytyksi".',
			'id_ID' => 'Ulasan Anda tidak berkontribusi pada peringkat perusahaan. Agar ulasan Anda memengaruhi peringkat perusahaan dan menerima status "Disetujui", tambahkan teks sebanyak 150 karakter atau lebih.',
		];
		$languages_15 = [
			'en_US' => 'Your review participates in the company\'s rating. Download documents to be considered credible.',
			'fr_FR' => 'Votre avis participe à la notation de l\'entreprise. Téléchargez les documents pour qu\'ils soient considérés comme "valides".',
			'de_DE' => 'Ihre Bewertung fließt in das Rating des Unternehmens ein. Laden Sie Dokumente herunter, die als "gültig" betrachtet werden.',
			'es_ES' => 'Su opinión participa en la calificación de la empresa. Descargue los documentos que se considerarán "válidos".',
			'ru_RU' => 'Ваш отзыв участвует в рейтинге компании. Для статуса «Достоверный» загрузите документы.',
			'pl_PL' => 'Twoja recenzja bierze udział w ocenie firmy. Pobierz dokumenty, które zostaną uznane za "Ważne".',
			'fi' => 'Arvostelusi osallistuu yrityksen luokitukseen. Lataa asiakirjat, joita pidetään "voimassa olevina".',
			'id_ID' => 'Ulasan Anda berpartisipasi dalam peringkat perusahaan. Unduh dokumen agar dianggap kredibel.',
		];
		$languages_16 = [
			'en_US' => 'Get "Reliable" status',
			'fr_FR' => 'Recevoir le statut "Fiable".',
			'de_DE' => 'Den Status "Zuverlässig" erhalten',
			'es_ES' => 'Recibir el estatus de "fiable".',
			'ru_RU' => 'Получите статус «Достоверный»',
			'pl_PL' => 'Otrzymać status "Niezawodny"',
			'fi' => 'Vastaanottaa "Luotettava"-statuksen',
			'id_ID' => 'Dapatkan status "Dapat Diandalkan"',
		];
		$languages_17 = [
			'en_US' => 'Credible',
			'fr_FR' => 'Crédible',
			'de_DE' => 'Glaubwürdig',
			'es_ES' => 'Creíble',
			'ru_RU' => 'Достоверный',
			'pl_PL' => 'Wiarygodny',
			'fi' => 'Uskottava',
			'id_ID' => 'Kredibel',
		];
		$languages_18 = [
			'en_US' => 'Download documents confirming your use of the company\'s services and affect its rating.',
			'fr_FR' => 'Téléchargez les documents confirmant votre utilisation des services de l\'entreprise et influencez sa notation.',
			'de_DE' => 'Laden Sie Dokumente herunter, die Ihre Inanspruchnahme der Dienstleistungen des Unternehmens bestätigen und seine Bewertung beeinflussen.',
			'es_ES' => 'Descargue los documentos que confirman su uso de los servicios de la empresa e influya en su calificación.',
			'ru_RU' => 'Загрузите документы, подтверждающие пользование услугами компании, и повлияйте на ее рейтинг.',
			'pl_PL' => 'Pobierz dokumenty potwierdzające korzystanie z usług firmy i wpłyń na jej ocenę.',
			'fi' => 'Lataa asiakirjoja, jotka vahvistavat yrityksen palvelujen käytön ja vaikuttavat sen luokitukseen.',
			'id_ID' => 'Unduh dokumen yang mengonfirmasi penggunaan layanan perusahaan dan memengaruhi peringkatnya.',
		];
		$languages_19 = [
			'en_US' => 'Your review includes supporting documents and participates in the company\'s rating',
			'fr_FR' => 'Votre évaluation comprend des documents justificatifs et contribue à la notation de l\'entreprise.',
			'de_DE' => 'Ihre Bewertung enthält Belege und trägt zum Rating des Unternehmens bei.',
			'es_ES' => 'Su revisión incluye documentos de apoyo y contribuye a la calificación de la empresa',
			'ru_RU' => 'Ваш отзыв содержит подтверждающие документы и участвует в рейтинге компании',
			'pl_PL' => 'Twoja opinia zawiera dokumenty uzupełniające i przyczynia się do oceny firmy',
			'fi' => 'Arvostelusi sisältää liiteasiakirjat ja vaikuttaa osaltaan yrityksen luokitukseen.',
			'id_ID' => 'Ulasan Anda menyertakan dokumen pendukung dan berpartisipasi dalam pemeringkatan perusahaan',
		];
		$languages_20 = [
			'en_US' => 'Leave the checkbox checked if everyone can see the files. Uncheck it if you want only us and the company representative to see the files.',
			'fr_FR' => 'Laissez la case cochée si les fichiers peuvent être vus par tous. Décochez-la si vous voulez que seuls nous et le représentant de l\'entreprise puissent voir les fichiers.',
			'de_DE' => 'Lassen Sie das Kästchen markiert, wenn die Dateien für alle sichtbar sind. Deaktivieren Sie diese Option, wenn Sie möchten, dass nur wir und der Vertreter des Unternehmens die Dateien sehen können.',
			'es_ES' => 'Deje la casilla marcada si los archivos pueden ser vistos por todos. Desmarca esta opción si quieres que sólo nosotros y el representante de la empresa podamos ver los archivos.',
			'ru_RU' => 'Оставьте галочку, если файлы могут видеть все. Уберите ее, если хотите, чтобы файлы увидели только мы и представитель компании.',
			'pl_PL' => 'Pozostaw pole zaznaczone, jeśli pliki mogą być widziane przez wszystkich. Usuń zaznaczenie, jeśli chcesz, aby tylko my i przedstawiciel firmy mogli zobaczyć pliki.',
			'fi' => 'Jätä valintaruutu rastitetuksi, jos tiedostot ovat kaikkien nähtävissä. Poista rasti, jos haluat, että vain me ja yrityksen edustaja näkevät tiedostot.',
			'id_ID' => 'Biarkan kotak centang dicentang jika semua orang dapat melihat file. Hapus centang jika Anda ingin hanya kami dan perwakilan perusahaan yang dapat melihat file tersebut.',
		];
		$languages_21 = [
			'en_US' => 'Your files will only be seen by a representative of the company.',
			'fr_FR' => 'Seul un représentant de l\'entreprise verra vos dossiers.',
			'de_DE' => 'Nur ein Vertreter des Unternehmens kann Ihre Dateien einsehen.',
			'es_ES' => 'Sólo un representante de la empresa verá sus archivos.',
			'ru_RU' => 'Ваши файлы увидит только представитель компании.',
			'pl_PL' => 'Tylko przedstawiciel firmy będzie widział Twoje pliki.',
			'fi' => 'Vain yrityksen edustaja näkee tiedostosi.',
			'id_ID' => 'Berkas Anda hanya akan dilihat oleh perwakilan perusahaan.',
		];
		$languages_22 = [
			'en_US' => '',
			'fr_FR' => '',
			'de_DE' => '',
			'es_ES' => '',
			'ru_RU' => '',
			'pl_PL' => '',
			'fi' => '',
			'id_ID' => '',
		];
		$languages_23 = [
			'en_US' => '',
			'fr_FR' => '',
			'de_DE' => '',
			'es_ES' => '',
			'ru_RU' => '',
			'pl_PL' => '',
			'fi' => '',
			'id_ID' => '',
		];
		$languages_24 = [
			'en_US' => '',
			'fr_FR' => '',
			'de_DE' => '',
			'es_ES' => '',
			'ru_RU' => '',
			'pl_PL' => '',
			'fi' => '',
			'id_ID' => '',
		];
		$languages_25 = [
			'en_US' => '',
			'fr_FR' => '',
			'de_DE' => '',
			'es_ES' => '',
			'ru_RU' => '',
			'pl_PL' => '',
			'fi' => '',
			'id_ID' => '',
		];
		$languages_26 = [
			'en_US' => '',
			'fr_FR' => '',
			'de_DE' => '',
			'es_ES' => '',
			'ru_RU' => '',
			'pl_PL' => '',
			'fi' => '',
			'id_ID' => '',
		];
		$languages_27 = [
			'en_US' => '',
			'fr_FR' => '',
			'de_DE' => '',
			'es_ES' => '',
			'ru_RU' => '',
			'pl_PL' => '',
			'fi' => '',
			'id_ID' => '',
		];
		$languages_28 = [
			'en_US' => '',
			'fr_FR' => '',
			'de_DE' => '',
			'es_ES' => '',
			'ru_RU' => '',
			'pl_PL' => '',
			'fi' => '',
			'id_ID' => '',
		];
		$languages_29 = [
			'en_US' => '',
			'fr_FR' => '',
			'de_DE' => '',
			'es_ES' => '',
			'ru_RU' => '',
			'pl_PL' => '',
			'fi' => '',
			'id_ID' => '',
		];
		$languages_30 = [
			'en_US' => '',
			'fr_FR' => '',
			'de_DE' => '',
			'es_ES' => '',
			'ru_RU' => '',
			'pl_PL' => '',
			'fi' => '',
			'id_ID' => '',
		];
		
		//
		
		$result = '';
		if($new_name != '') {
			$company_name = $new_name;
			$result .= '<h1>'.$languages_1[$languages].' '.$company_name.'</h1>';
			$result .= '<div class="review_change_company"><a href="'.get_bloginfo('url').'/add-review/" rel="nofollow">'.$languages_2[$languages].'</a></div>';
		} else {
			$company_name = get_field('company_name',$post_id);
			$result .= '<h1 class="title_reviwe_single_new">'.$languages_3[$languages].'</h1>';
			$result .= '<span class="color_light_gray font_smaller_2">'.$languages_4[$languages].'</span>';
			$result .= '<div class="new_form_block new_form_block_title_wrapper new_form_block_header"><span class="title_reviwe_single_new_company font_new_medium color_dark_blue m_b_10 font_bold">'.$company_name.'</span><span class="close close_review_main_company"></span></div>';
			//$result .= '<div class="review_change_company"><a href="'.get_bloginfo('url').'/add-review/">'.__('Я хочу написать отзыв о другой компании','er_theme').'</a></div>';
		}
		
		$result .= '<div class="form_separate_review_single">';
		
		if($post_id == 0) {
			$rating_fields_group = 87485;
		} elseif(get_post_type($post_id) == 'casino') {
			$rating_fields_group = get_rating_fields_group($post_id);
			
			
		}
		$ratings = get_comment_rating_fields($rating_fields_group,'key');
		//if($rating_fields_group != 0) {
		$result .= '<form action="'.admin_url( 'admin-ajax.php' ).'" method="post" id="popup_form_review_newform" class="clickable newformpopupcomment">';
		$result .= print_css_links('review_form');
		if ($_COOKIE["_ym_uid"]) {
			$timervop = htmlspecialchars($_COOKIE["_ym_uid"]);
			$result .= '<input type="hidden" name="ym_uid" value="'.$timervop.'" />';
			// update_field('client_id_yandex', $timervop, 'user_'.$user_id);
		}
		
		$result .= '<input type="hidden" name="action" value="new_submit_review_newform2" />';
		$result .= '<input type="hidden" name="type_send" value="review" />';
		$result .= '<input type="hidden" name="post_id" value="'.$post_id.'" />';
		if($post_id == 0 && $new_name != '') {
			$result .= '<input type="hidden" name="new_name" value="'.$new_name.'" />';
		}
		
		//



		if(!empty($ratings)) {
			$result .= '<div class="new_form_block has_notice">';
			$result .= '<div class="notice" id="ratestatus"><span class="notice-title" attr-negative="'.strip_tags($languages_5[$languages]).'" attr-normal="'.strip_tags($languages_6[$languages]).'">'.$languages_6[$languages].'</span>
				<span class="color_dark_blue" attr-negative="'.strip_tags($languages_7[$languages], '<a>').'" attr-normal="'.strip_tags($languages_8[$languages]).'">'.$languages_8[$languages].'</span></div>';
			$result .= '<div class="new_form_block_title color_dark_blue font_bolder font_smaller_2 font_uppercase">'.$languages_9[$languages].'</div>';
			$result .= '<div class="new_form_block_content">';
			$result .= '<div class="rating_columns flex">';
			
			foreach ($ratings as $item) {
				$result .= '<div class="form_rating flex">';
				$result .= '<div class="form_field_name color_dark_gray font_smaller">'.$item['field_label'].'</div>';
				$result .= '<div class="rating m_b_15">';
				$result .= rating_field($item['field_min'],$item['field_max'],'rating',$item['field_name']);
				$result .= '</div>';
				$result .= '</div>';
			}

			
			$result .= '</div>';
			$result .= '</div>';
			$result .= '</div>';


		}



		// $("#popup_form_review_newform").on("click", function () {
		// 	const ratings = $(".rating");
		// 	let counter = 0;
		// 	ratings.each(function () {
		// 	  const name = $(this).find("input").attr("name");
		// 	  const val = $(`input[name="${name}"]:checked`).val();
		// 	  if (val) {
		// 		counter++;
		// 	  }
		// 	});
		  
		// 	if (ratings.length === counter) {
		// 	  $(".notice").hide();
		// 	}
		//   });


		
		$result .= '<div class="flex flex_wrap">';
		$result .= '<div class="single_newform_left how_long">';
		$result .= '<div class="line_title">'.$languages_10[$languages].'</div>';
		$result .= '<select name="review_year"class="m_b_20">';
		$result .= '<option value="2023" selected>'.__('2023','er_theme').'</option>';
		$result .= '<option value="2022">'.__('2022','er_theme').'</option>';
		$result .= '<option value="2021">'.__('2021','er_theme').'</option>';
		$result .= '<option value="2020">'.__('2020','er_theme').'</option>';
		$result .= '<option value="2019">'.__('2019','er_theme').'</option>';
		$result .= '<option value="2018">'.__('2018','er_theme').'</option>';
		$result .= '<option value="2017">'.__('2017','er_theme').'</option>';
		$result .= '<option value="2016">'.__('2016','er_theme').'</option>';
		$result .= '<option value="2015">'.__('2015','er_theme').'</option>';
		$result .= '</select>';
		$result .= '</div>';
		$result .= '<div class="single_newform_right right_recommend">';
		$result .= '<div class="title">'.$languages_11[$languages].' *</div>';
		$result .= '<div class="checkbox_container font_small color_dark_blue">';
		$result .= '<input type="radio" id="recomend_for_friends" name="recomend_for_friends"  class="custom-checkbox" value="yes">';
		
		$result .= '<label for="recomend_for_friends" class="m_right_10">'.__('Да','er_theme').'</label>';
		
		$result .= '<input type="radio" id="recomend_for_friends_no" name="recomend_for_friends"  class="custom-checkbox" value="no">';
		$result .= '<label for="recomend_for_friends_no">'.__('Нет','er_theme').'</label>';
		$result .= '</div>';
		
		$result .= '</div>';
		$result .= '<div class="single_newform_left pm_cont">';
		
		$result .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase">'.__('Плюсы','er_theme').'</div>';
		$result .= '<div class="plus_minus_container plus">';
		$result .= '<input type="text" name="review_pluses[]" value="" class="" placeholder="'.__('Введите текст..','er_theme').'" />';
		$result .= '<div class="plus" data-total="1">+</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '<div class="single_newform_right pm_cont">';
		$result .= '<div class="title color_dark_blue font_bolder font_smaller_2 font_uppercase">'.__('Минусы','er_theme').'</div>';
		$result .= '<div class="plus_minus_container minus">';
		$result .= '<input type="text" name="review_minuses[]" value="" class="" placeholder="'.__('Введите текст..','er_theme').'" />';
		$result .= '<div class="plus" data-total="1">+</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '</div>';
		$result .= '<div class="new_form_block has_notice has_notice_text_comment">';
		$result .= '<div class="notice"><span class="notice-title">Добавьте заголовок</span><span class="color_dark_blue">'.__('Укажите главную мысль отзыва. Упоминать название компании в заголовке не нужно. ','er_theme').'</span></div>';
		$result .= '<div class="new_form_block_line_input">';
		$result .= '<div class="line_title">'.__('Заголовок','er_theme').' *</div>';
		$result .= '<input type="text" name="review_title" value="" class="" />';
		$result .= '</div>';
		$result .= '<div class="notice-relative" id="get_status"><div class="notice"><span class="notice-title" attr-negative="'.strip_tags($languages_12[$languages]).'" attr-normal="'.strip_tags($languages_13[$languages]).'" attr-good="'.strip_tags($languages_13[$languages]).'"></span><span class="color_dark_blue" attr-negative="'.strip_tags($languages_14[$languages]).'" attr-normal="'.strip_tags($languages_15[$languages]).'" attr-good="'.strip_tags($languages_15[$languages]).'">'.$languages_14[$languages].'</span></div></div>';
		$result .= '<textarea name="comment_text" class="m_b_20" placeholder="'.__('Текст отзыва','er_theme').' *"></textarea>';
		$result .= '<ul class="review_form_icons flex">';
		//$result .= '<li class="form_icon_img inactive"><span class="form_icon_img_inside"></span><span class="add_image_text"><span>Добавить изображение</span></span></li>';
		$result .= '<li class="form_icon_notify inactive"><span class="form_icon_notify_inside"></span><span class="subs_comments"><span>Подписаться на ответы компании</span></span></li>';
		//$result .= '<li class="form_icon_link inactive"></li>';
		$result .= '</ul>';
		$result .= '</div>';
		$result .= '<input type="hidden" name="pubhidefiles" value="pub">';
		$result .= '<div class="new_form_block has_notice"><div class="notice" id="imgstatus"><span class="notice-title" attr-negative="'.strip_tags($languages_16[$languages]).'" attr-normal="'.strip_tags($languages_17[$languages]).'">'.$languages_16[$languages].'</span>
<span class="color_dark_blue" attr-negative="'.strip_tags($languages_18[$languages]).'" attr-normal="'.strip_tags($languages_19[$languages]).'">'.$languages_18[$languages].'</span></div><div class="notice" id="pubmain"><span class="notice-title">Кто может увидеть ваши файлы?</span>
<span attr-good="'.strip_tags($languages_20[$languages]).'" attr-negative="'.strip_tags($languages_21[$languages]).'">'.$languages_20[$languages].'</span></div><div class="new_form_block_title color_dark_blue font_bolder font_smaller_2 font_uppercase proofrev"><span class="prof_title">Достоверность отзыва</span><span class="prof_desc">Отзыв с подтверждающими документами вызывает <a href="/reliable-review/" class="proffdoc" target="_blank">больше доверия</a>.</span></div>';
		$result .= '<div class="text_new_form flex	text_new_form_publish"><span class="publish_wrap"><span class="publish_wrap_title">Опубликовать</span>
<span  class="publish_wrap_buttons"><span class="publish_accept"></span></span>
</span>
<span class="file_doc" style="display: none;"><input type="file" id="file_doc" enctype="multipart/form-data" multiple></span>
<span class="publish_title"><div class="form_add_images_2 flex" id="img_uploaded"><span class="img-upload" id="img-upload"><svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M24 17V24M24 24V31M24 24H17M24 24H31" stroke="#222222" stroke-width="2" stroke-linecap="round"></path>
</svg></span></div>
Фотографии чека, товара, договора, скриншоты личного кабинета и другие документы.
<br>До 10 файлов, до 2 мегабайт каждый, расширения: png, jpg, jpeg, pdf.
</span></div>';
		$result .= '</div>';
		
		$result .= '<div class="review_single_button_container_width">';
		$result .= '<input type="text" name="form_type" value="new" style="display: none">';
		$result .= '<input class="button button_big button_green m_b_10 pointer font_small font_bold" type="submit" value="'.__('Опубликовать отзыв','er_theme').'" />';
		$result .= '<div class="button button_big button_border m_b_10 pointer font_small font_bold preview_review stepman clickable">'.__('Предпросмотр','er_theme').'</div>';
		$result .= '</div>';
		
		$result .= '</form>';
		$result .= '<div class="preview"></div>';
		$result .= '</div>';
		return $result;
	}
}
if(!function_exists('review_form_separate_new')) {
	function review_form_separate_new($post_id) {
		$result = '';
		$result .= '<div class="review_form_separate">';
		$result .= '<div class="wrap flex_column">';
		if($post_id != 0) {
			//$company_name = get_field('company_name',$post_id);
			//$result .= '<h1>'.__('Новый отзыв о компании','er_theme').' '.$company_name.'</h1>';
			//$result .= '<div class="review_change_company"><a href="'.get_bloginfo('url').'/add-review/">'.__('Я хочу написать отзыв о другой компании','er_theme').'</a></div>';
			$result .= form_separate_review_single_new($post_id);
		} else {
			$result .= '<h1>'.__('Новый отзыв','er_theme').'</h1>';
			$result .= '<div class="autocomplete_container" data-type="search_companies" id="popup_search_companies">';
			$result .= '<input name="autocomplete_text" type="text" value="" placeholder="'.__('Введите название компании','er_theme').'" />';
			$result .= '<input name="autocomplete_result" type="hidden" value="" />';
			$result .= '<div class="autocomplete_icon_search"></div>';
			$result .= '<div class="autocomplete_icon_close"></div>';
			$result .= '<div class="autocomplete_search_results"></div>';
			$result .= '</div>';
			$result .= '<div class="outside_form_container"></div>';
		}
		
		
		$result .= '</div>';
		$result .= '</div>';
		$result .= '
		<style>.notice-relative {
			position: relative;
		}
		
		.has_notice .notice:before {
			margin-bottom: 15px;
		}
		
		.notice-title {
			position: absolute;
			top: -1px;
			left: 25px;
			font-size: 18px;
			font-weight: bold;
			// white-space: nowrap;
			font-size: 16px;
		}
		
		.has_notice .notice {
			position: absolute;
			width: 280px;
			right: -300px;
			font-size: 14px;
			line-height: 16px;
			letter-spacing: 0.02em;
			top: 0;
			height: unset;
			color: #001640;
		}
		
		.notice-relative .notice {
			top: 20px;
		}
		
		.notice .color_dark_blue {
			font-size: 14px;
		}
		
		.close_review_main_company {
			background: url(/wp-content/themes/eto-razvod-1/img/close.svg);
			width: 22px;
			height: 22px;
			position: absolute;
			background-repeat: no-repeat;
			right: 20px;
			top: 0;
			bottom: 0;
			margin: auto;
			cursor: pointer;
		}
		
		.new_form_block_header {
			position: relative;
		}
		
		.title_reviwe_single_new {
			margin-bottom: 0;
		}
		
		.new_form_block_title_wrapper {
			padding: 20px 35px;
			margin-top: 15px;
		}
		
		.publish_wrap_buttons {
			display: flex;
		}
		
		.publish_wrap {
			display: flex;
			display: block;
			display: flex;
			height: 30px;
			align-items: center;
		}
		
		.publish_accept {
			background: url(/wp-content/themes/eto-razvod-1/img/checkboxboxrev.svg);
			width: 20px;
			height: 20px;
			display: block;
			background-size: contain;
		}
		
		.publish_cancel {
			background: url(/wp-content/themes/eto-razvod-1/img/cancel-publish.svg);
			width: 20px;
			height: 20px;
			display: block;
			background-size: contain;
		}
		
		.publish_wrap_title {
			font-weight: 600;
			font-size: 16px;
		}
		
		.publish_wrap_buttons {
			margin-left: 15px;
		}
		
		.publish_wrap_buttons span {
			margin: 5px;
		}
		
		.publish_title {
			display: flex;
			flex-direction: column;
			align-items: center;
			color: #837F7F;
			font-size: 14px;
			text-align: center;
			margin-top: -15px;
		}
		
		.publish_title img {
			margin-bottom: 10px;
		}
		
		.text_new_form_publish {
			align-items: center;
			padding: 10px;
			justify-content: space-around;
			padding-top: 0;
			padding-right: 20px !important;
		}
		.proofrev {
			border-bottom: none;
		}
		.img-upload {
			display: block;
			cursor: pointer;
		}
		.new_form_block .review_form_icons {
			margin-bottom: 0px;
		}
		
		/*.new_form_block .review_form_icons {
			margin-bottom: 0;
		}*/
		
		/*.review_form_icons .form_icon_img {
			position: absolute;
			bottom: 10px;
			left: 0;
		}*/
		
		#popup_form_review_newform textarea {
			margin: 0 !important;
			resize: vertical;
			display: block;
			height: 350px;
			padding-bottom: 70px !important;
		}
		
		.publish_accept.publish_not_accept {background: url(/wp-content/themes/eto-razvod-1/img/checkboxboxrev-notclick.svg);}
		
		.img_status_wrapper > svg {
			width: 100%;
			height: 100%;
		}
		
		.img_status_wrapper {
			width: 18px;
			height: 18px;
			display: block;
			margin-left: 5px;
		}
		
		.comment-author {
			position: relative;
			display: flex;
		}
		
		#ratestatus .notice-title + span a {
			color: #000;
			text-decoration: none;
			border-bottom: 1px solid;
		}
		
		#pubmain {
			bottom: -15px !important;
			height: 100px !IMPORTANT;
			top: unset !important;
		}
		#img_uploaded li {
			width: 50px;
			height: 50px;
		}
		
		#img-upload {
			width: 50px;
			height: 50px;
			border: 1px dashed #DDDDDD;
			border-radius: 4px;
			margin: 5px;
		}
		
		#popup_form_review_newform .review_form_icons li {
			height: 32px;
			padding-left: 15px;
			padding-right: 15px;
			margin: 0;
			margin-bottom: 10px;
		}
		
		#popup_form_review_newform .review_form_icons li .form_icon_img_inside {
			width: 15px;
			height: 15px;
			-webkit-mask-size: contain;
			mask-size: contain;
		}
		#popup_form_review_newform textarea {
			resize: none;
		}
		
		
		.publish_title {
			font-size: 12px;
			margin-top: 15px;
		}
		
		.text_new_form_publish {
			align-items: center;
			padding: 35px;
			justify-content: space-between;
			padding-top: 0;
			padding-right: 20px !important;
		}
		
		.proofrev {
			border-bottom: 1px solid #F0F0F0;
		}
		
		.text_new_form_publish {
			padding-bottom: 10px;
		}
		
		.form_add_images_2 {
			margin-bottom: 10px;
		}
		.publish_title {
			position: relative;
			font-size: 12px;
		}
		
		
		.proofrev {
			position: relative;
		}
		
		.proofrev:before {
			content: " ";
			width: 1px;
			height: calc(100% - 20px);
			background: #DDDDDD;
			position: absolute;
			top: 0;
			left: 260px;
			bottom: 0;
			margin: auto;
		}
		
		.text_new_form_publish {
			position: relative;
		}
		
		.text_new_form_publish:before {
			content: " ";
			width: 1px;
			height: calc(100% - 20px);
			background: #DDDDDD;
			position: absolute;
			top: 0;
			left: 260px;
			bottom: 0;
			margin: auto;
		}
		
		.prof_desc {
			font-weight: normal;
			position: absolute;
			text-transform: none;
			left: 280px;
			line-height: 1.1;
			font-size: 16px;
		}
		
		.proffdoc {
			text-decoration: none;
			color: #000000;
			border-bottom: 1px solid;
		}
		
		#img_uploaded {
			max-width: 500px;
			display: flex;
			align-items: center;
			justify-content: center;
		}
		
		#img_uploaded > li {margin: 5px;}
		
		.status_comment_a {
			font-weight: normal;
		}
		
		.previe23 .set_status {
			position: unset !important;
			left: unset !important;
			top: unset !important;
			margin: unset !important;
			margin-left: 5px !important;
		}
		.previe23 .li_statusbad + .comment_rating_details {
			display: none;
		}
		/*.proffdoc {
			text-decoration: none;
			color: #000000;
			border-bottom: 1px solid;
		}
		
		.proofrev {
			padding-bottom: 15px;
			position: relative;
			display: flex;
			flex-direction: column;
		}*/
		
		.comment_attached_files_list {
			list-style: none;
			margin: 0;
			padding: 0;
			display: flex;
			flex-wrap: wrap;
			margin-bottom: 20px;
		}
		
		.comment_attached_files_list li {
			margin: 0;
			padding: 0;
			margin-right: 15px;
			flex: 0 0 calc(120px);
			width: 120px;
			height: 120px;
			border: 1px solid #E9F0F3;
		}
		
		.comment_attached_files_list li a {
			display: block;
			width: 120px;
			height: 120px;
			background-size: contain;
			background-repeat: no-repeat;
			background-color: #FFF;
		}
		.previe23 .set_status {
			right: 0 !important;
			position: absolute !important;
		}
		
		.set_status:before {
			font-weight: normal;
		}
		
		@media screen and (max-width: 1300px) {
		.has_notice .notice {
				right: 20px;
				top: 20px;
				width: 20px;
			}
		
			.has_notice .notice span {
				display: none;
			}
		
			.has_notice .notice:hover span {
				display: block;
				position: absolute;
				right: 0;
				width: 180px;
				background-color: #FFF;
				border: 1px solid #EEF3F9;
				padding: 10px 15px;
				top: 20px;
				z-index: 10;
			}
		
			.right_recommend.has_notice .notice {
				right: 10px;
				top: 30px;
				width: 20px;
			}
		
			.has_notice_text_comment.has_notice .notice {
				top: 30px;
			}
		
			.review_form_separate .wrap {
				max-width: 850px;
				padding-right: 0;
			}
			
		.new_form_block.has_notice {
			width: calc(100% - 2px) !important;
		}
		
		.prof_desc {
			position: relative;
			left: 0;
		}
		
		.new_form_block_title.color_dark_blue.font_bolder.font_smaller_2.font_uppercase.proofrev {
			display: flex;
			flex-direction: column;
			text-align: center;
		}
		
		.proofrev:before {
			opacity: 0;
		}
		
		.text_new_form.flex.text_new_form_publish {
			display: flex;
			flex-direction: column-reverse;
		}
		
		.text_new_form_publish:before {
			opacity: 0;
		}
		
		span.prof_title {
			margin-bottom: 20px;
		}
		
		span.publish_wrap {
			margin-top: 20px;
		}
		
		ul.review_form_icons.flex {
			display: flex;
			align-items: center;
		}
		
		.has_notice_text_comment.has_notice .notice {
			/* position: relative; */
			/* left: 0; */
		}
		
		.has_notice .notice {
			right: 20px;
			top: 20px;
			width: 20px;
			z-index: 111;
		}
		
		
		.notice-title {
			display: none !important;
		}
		
		#pubmain {
			bottom: 4px !important;
			height: unset !important;
		}
		
		#imgstatus {top: 17px;}
		
		#ratestatus {
			top: 18px;
		}
		.has_notice .notice {
			z-index: 1;
		}
		
		.has_notice .notice span {
			z-index: 2;
		}
		
		
		div#get_status {
			z-index: 0;
		}
		}
		
		@media screen and (max-width: 450px) {
		.recomend_for_friends {
			display: none;
		}
		
		.previe23 .set_status {
			position: relative !important;
			left: 0 !important;
			left: 45px !important;
		}
		
		.comment-author {
			display: flex;
			flex-direction: column;
		}
		
		.comment-author {
			margin-bottom: 20px;
		}
		}
		.previe23 .set_status {
			position: relative !important;
			left: unset !important;
			right: unset !important;
			margin: 0 !important;
		}
		
		.previe23 .set_status:before {
			display: none;
		}
		
		.previe23 .status_comment_a {
			left: -136px !important;
			right: -136px !important;
			margin: auto !important;
		}
		
		span.status_main {
			font-weight: normal;
			display: flex;
			font-size: 12px;
			line-height: 23px;
			margin-left: 10px;
		}
		
		span.status_main > .set_status {
			margin-left: 5px !important;
		}
		</style><script>i = 0;
		$("textarea[name=\"comment_text\"]").on("input", function(){
			if (i == 0){
				i = 1;
				$("#get_status .notice-title").text($("#get_status .notice-title").attr("attr-negative"));
				$("#get_status .notice-title + span").text($("#get_status .notice-title + span").attr("attr-negative"));
			}
			if ($(this).val().length < 149) {
				$("#get_status").attr("idstatus","1");
				$("#get_status .notice-title").text($("#get_status .notice-title").attr("attr-negative"));
				$("#get_status .notice-title + span").text($("#get_status .notice-title + span").attr("attr-negative"));
				$("#get_status .notice-title").css("color","#FC1010");
			} else {
				$("#get_status").attr("idstatus","2");
				$("#get_status .notice-title").text($("#get_status .notice-title").attr("attr-good"));
				$("#get_status .notice-title + span").text($("#get_status .notice-title + span").attr("attr-good"));
				$("#get_status .notice-title").css("color","#FE8312");
			}
		});
		
		$(\'body\').on(\'click\',\'.img-upload\',function(){
		$(\'input#file_doc\').val(\'\');
				$(\'input#file_doc\').trigger(\'click\');
		});

				
		$("#file_doc").on("change", function(){
			if ($(this).val() != "") {
				/*$("div#get_status").hide();
				$("#imgstatus").attr("idstatus","1");
				$("#imgstatus .notice-title").text($("#imgstatus .notice-title").attr("attr-normal"));
				$("#imgstatus .notice-title + span").text($("#imgstatus .notice-title + span").attr("attr-normal"));
				$("#imgstatus .notice-title").css("color","#4CA109");*/
			} else {
				$("div#get_status").show();
				$("#imgstatus").attr("idstatus","2");
				$("#imgstatus .notice-title").text($("#imgstatus .notice-title").attr("attr-negative"));
				$("#imgstatus .notice-title + span").text($("#imgstatus .notice-title + span").attr("attr-negative"));
				$("#imgstatus .notice-title").attr("style","");
			}
		 
		});
		
		$("body").on("click",".publish_accept",function(){
			$(this).toggleClass("publish_not_accept");
			console.log($(this).attr("class"));
			if ($(this).attr("class") == "publish_accept publish_not_accept") {
				$("input[name=\'pubhidefiles\']").val("hide");
				$("#pubmain .notice-title + span").text($("#pubmain .notice-title + span").attr("attr-negative"));
			} else {
				$("input[name=\'pubhidefiles\']").val("pub");
				$("#pubmain .notice-title + span").text($("#pubmain .notice-title + span").attr("attr-good"));
			}
			
		});
		
		$("body").on("change", "#file_doc", function() {
				/*var file_data = $(this).prop("files")[0];
				console.log(file_data);
				var append_id = "img_uploaded";
				ajax_upload_file_2(file_data,append_id);*/
				
				
				/*console.log($(this).prop("files"));
				console.log(typeof $(this).prop("files"));*/
				let t = $(this).prop("files");
		
		
				for (const [key, value] of Object.entries(t)) {
					var file_data = $(this).prop("files")[key];
					var append_id = "img_uploaded";
					ajax_upload_file_2(file_data,append_id);
				}
		
			});
		</script>';
				$languages = get_locale();
				if ($languages != 'ru_RU') {
					$result .= '<style>.publish_title {
			font-size: 9px;
		}
		
		.single_newform_right.right_recommend .title {
			font-size: 12px !important;
		}
		
		.single_newform_right.right_recommend {}
		
		.single_newform_left.how_long .line_title {
			font-size: 10px !important;
			padding-right: 10px !important;
		}
		</style>';
				}
				echo $result;
			}
		}