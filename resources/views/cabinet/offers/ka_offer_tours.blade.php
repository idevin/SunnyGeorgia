@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">
                        ტურისტული  მომსახურების უზრუნველყოფის ხელშეკრულება
                        საჯარო ოფერტი
                    </h3>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                                    <h3 class="m-portlet__head-text">
                                        ტურისტული  მომსახურების უზრუნველყოფის ხელშეკრულება
                                        საჯარო ოფერტი
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <div class="m-portlet__body cms-content">

                            <p>აღნიშნული ხელშეკრულების (შემდგომში– ხელშეკრულება) მხარეები:</p>
                            <p>ერთის მხრივ, შპს "სანნი ჯორჯია ტრეველ" (SunnyGeorgia.Travel), (ს/ნ 42001349), მისამართი მ. აბაშიძეს 50, ბათუმი,(შემდგომში – «SunnyGeorgia.Travel») დამეორეს მხრივ  კანომდებლობის შესაბამისად ქმედუნარიანი ფიზიკური პირი, რომელიც მიიჩნევა სამოქალაქო ურთიერთობების მონაწილედ, ან კანომდებლობის შესაბამისად  უფლებაუნარიანობის მქონე იურიდიული პირი, რომელიც ეთანხმება აღნიშული ხელშეკრულების პირობებს (შემდგომში –ტურ_ოპერატორთან).</p>
                            <p>ტერმინთა განმარტება</p>
                            <p><strong>საიტი , სერვისი</strong> – ინტერნეტ სივრცეში განთავსებული მონაცემების კომპლექსი, (ვებ გვერდი), ერთი თემით, დიზაინით და დომენის სივრცეში ერთიანი მისამართით <a href="https://sunnygeorgia.travel">www.sunnygeorgia.travel</a> და მისი სუბდომენები. საიტის (სერვისი) საწყისი გვერდი რომელიც განთავსებულია  ინტერნეტ სივრცეში მისამართზე: <a href="https://sunnygeorgia.travel">www.sunnygeorgia.travel</a></p>
                            <p><strong>ექაუნთი</strong> - ელექტრონული მონაცემთა კომპლექსი, (რომელიც დაცულია საიტის ტექნიკური საშუალებებით )  რომელის  მეშვეობით გადამზიდავი  საიტზე აქვეყნებს ინფორმაციას  თავის შესახებ, რომლის მიშევეობითაც ხდება გადამზიდავის ინდივიდუალიზაცია.</p>
                            <p><strong>კონტენტი</strong> – საიტის ნებისმიერი ინფორმაციული და პროგრამული უზრუნველყოფა, მათ შორის, (მაგრამ ამით არ შემოიფარგლება): ტექსტები, რეცენზიები, კომენტარები, ანონსები , ფოტო და / ან ვიდეო მასალები, ელემენტები, დიზაინი, ილუსტრაციები, სკრიპტები, კომპიუტერული პროგრამები, (მათ შორის, თამაშები და პროგრამები), მონაცემებთა ბაზა, რომელიც საიტზეა გამოქვეყნებული.</p>
                            <p><strong>ტურისტული  პროდუქტი (მომსახურება)</strong> – ტურისტული პროდუქტი (მომსახურება)– მომსახურება ან მომსახურების კომპლექსი, რომელის საჭიროა კლიენტის მოთხოვნია დასაკმაყოფილებლად მაგის ტურისთული მოგზაურების ან საქმიანი მიმოვლინების დროს, რომელიც შეიცავს მაგრამ არ იზღუდება: ფართის  ქირაობა, ტური, საექსკურსიო მომსახურება, ტრანსპორტის ქირაობა.  ტურისტული მომსახურების კომპლექსი, ტურ_ოპერატორის მიერ წარმოდგენილი პირობები  მესამე პირებისთვის. კლიენტების მომსახურებას ანხორციელებს ტუროპერატორი პირობებზე რომელსაც თითონ აყალიბებს.</p>
                            <p><strong>კლიენტი, კლიენტები</strong> – ფიზიკური ან / და იურიდიული პირები, რომლებიც გამოხატავენ  თავიანთი სურვილს დადონ გარიგება „ტურ_ოპერატორთან“ ტურისტული პროდუქტის შეძენის მიზნით, აგრეთვე, ფიზიკური ან / და იურიდიული პირები, რომლებმაც გააფორმეს „ტურ_ოპერატორთან“ გარიგება (გარიგებები).</p>
                            <p><strong>გარიგება, გარიგებები</strong> – საიტის ტექნიკური საშუალებებით  ტურ_ოპერატორსა და მესამე პირის შორის დადებული ტურისტული მომსახურების კომპლექსის ხელშეკრულება. ხელშეკრულების გაფორმების მომენტად ითვლება კლიენტის მიერ ტურისტული პროდუქტით სარგებლობის დასტური, (საიტის ტექნიკური საშუალებებით წინასწარ გადახდის (ავანსის) შეტანით).</p>

                            <h4>2. ხელშეკრულების საგანი, ზოგადი დებულებები</h4>
                            <p>2.1  აღნიშნული ხელშეკრულებით ტურ_ოპერატორი ავალდებულებს SunnyGeorgia.Trave-ს,  ხოლო SunnyGeorgia.Travel-ი ანაზღაურების სანაცვლოდ, იღებს ვალდებულებას თავისი სახელით, მაგრამ ტურ_ოპერატორის ხარჯზე შეასრულოს ტურ_ოპერატორის დავალებები; კერძოდ: განახორციელოს ისეთი ქმედებები, რომლითაც უზრუნველყოფს კლიენტების მოზიდვას და მათ ინფორმირებას,  რომლებმაც გამოხატეს  თავიანთი სურვილი დადონ გარიგებები „ტურ_ოპერატორთან“ (ტურ_ოპერატორისთვის საიტის გამოყენების საშუალების მიცემის გზით):
                            საიტის გამოყენების საშუალებით მისცეს კლიენტს და ტურ_ოპერატორს ტექნიკური შესაძლებლობა გარიგების დასადებად, განახორციელონ ელექტრონულ საკომუნიკაციო არხების  საშუალებით ტურ_ოპერატორის ინფორმირება კლინტების  სურვილის შესახებ გარიგებების დადებაზე; კლიენტისა ( კლიენტების) და ტურ_ოპერატორის ყოველი გარიგების გაფორმების მომენტში მიიღოს კლიენტისგან ტურ_ოპერატორის სახელით და მის ხარჯზე ტურისტული  პროდუქტის ღირებულების თანხის წინასწარი გადასახადი (ავანსი) ტურისტული პროდუქციის ღირებულიბის 10% ოდენობით. (მოცემული პროცენტული რაოდენობა შესაძლოა იყოს ცვალებადი), ხოლო კლიენტის ან/და ტურ_ოპერატორის  ცალმხრივი უარის  შემთხვევაში გარიგების  შესრულებაზე, – კლიენტს უბრუნებს ტურ_ოპერატორის სახელით და მის ხარჯზე  მიღებულ წინასწარ გადახდილ თანხას (გარიგების პირობების  გათვალისწინებული წესებით, ოდენობითა და შემთხვევებით).
                                კლიენტისგან (რომელმაც გააფორმა გარიგება ტურ_ოპერატორთან)   წინასწარი გადახდის მიღების შემდგომ, უნდა გადასცეს კლიენტს და ტურ_ოპერატორს ერთმანეთის საკონტაქტო მონაცემები  და კლიენტს აცნობოს ყველა იმ ინფორმაციის შესახებ, რომელიც მიიღო ტურ_ოპერატორისგან გარიგებების შესრულებასთან  დაკავშირებით. SunnyGeorgia.Travel-ი ტურ_ოპერატორის სახელით არ აფარმებს კლინტთან გარიგებას.</p>

                            <h4>3. მხარეების უფლებები და მოვალეობები :</h4>
                            <p>3.1 ტურ_ოპერატორი ვალდებულია:</p>
                            <p>3.1.1 განათავსოს საიტზე, თავის ექაუნტში  ტურისტული  პროდუქტის შესახებ ინფორმაცია, რომელიც კლინტსა და SunnyGeorgia.Travel-ს საშუალებას აძლევს  დაადგინონ რომ ინფორმაცია ტურისტული  პროდუქტების შესახებ განთავსებულია სიზუსტით ტურ_ოპერატორის მიერ.</p>
                            <p>3.1.2  ტურ-ოპერატორს ეკრძალება საიტზე  თავისუფალი ხელმისაწვდომობის ფორმით განათავსოს თავისი საკონტაქტო მინაცემები (მათ შორის სატელეფონო, ელექტრონული ფოსტის მისამართი) და არანაირი სხვა ხერხით   დამოუკიდებლად  არ შეატყობინოს კლიენტს მითითებული მონაცემები (მათ შორის საიტის მიღმა არაპირდაპირი გზით) წინასწარი გადახდის მომენტამდე.</p>
                            <p>3.1.3 ექაუნთის შექმნისას განათავსოს საკუთარ თავზე და  ტურისტული  პროდუქტზე ზუსტი, კორექტული და სრული ფორმით აუცილებელი ინფორმაცია, რომელიც იძლევა  ტურ_ოპერატორისა და ტურისტული  პროდუქტის ინდივიდუალიზაციის საშუალებას.</p>
                            <p>3.1.4 დაიცვას ექაუნთის სახელის და პაროლის კონფიდენციალურობა, აგრეთვე აიღოს პასუხილმგებლობა მესამე პირისა და საკუთარ ნებისმიერ ქმედებაზე, რომელიც განახორციელა ექაუნთის სარგებლობის დროს.</p>
                            <p>3.1.5 საიტზე ჰქონდეს მხოლოდ ერთი ექაუნტი.</p>
                            <p>3.1.6 აცნობოს SunnyGeorgia.Travel-ს ყველა შემთხვევის შესახებ, რომელიც გახდა ტურ_ოპერატორისთვის ცნობილი მესამე პირების მიერ ექაუნთის გამოყენების შესახებ.</p>
                            <p>3.1.7 ტურისტული  მომსახურების უზრუნველყოფის დროს არ დაარღვიოს ასეთი მომსახურების გამწევი (მასპინძელი) ქვეყნის კანონები.</p>
                            <p>3.1.8 ექაუნთსა და საიტზე განთავსებული მომაცემების წაშლის საფრთხის გამო არ განათავსოს კანონმდებლობით და აღნიშნული ხელშეკრულებით აკრძალური ინფორმაცია.</p>
                            <p>3.1.9. არ დააზიანოს სერვისი და არ განახორციელოს ისეთი  ქმედებები, რომელიც შესაძლოა გახდეს საიტზე სრულად  ან ნაწილობრივად მონაცემების დაკარგვის მიზეზი; აგრეთვე პროვაიდერის მიერ, საიტის მომხმარებელთა შეუზღუდავი  წრის რაოდენობის  დაბლოკვის მიზეზი.</p>
                            <p>3.1.10. საიტის მიშვეობით არ გაუკეთოს რეკლამა მესამე პირების მომსახურებას, არ განათავსოთ საიტზე მესამე პირების საკონტაქტო ინფორმაცია, არ გასცეს უფლება მესამე პირებზე ტურ_ოპერატორის ექაუნთის ქვეშ ისარგებლონ საიტით.</p>
                            <p>3.1.11. არ განათავსონ საიტზე ინფორმაცია, მასალები და სხვა მონაცემები რომლებიც დაარღვევენ  ინტელექტუალური საკუთრების შესახებ კანონმდებლობას.</p>
                            <p>3.1.12 სრულად განახორციელოს თავიანთი უფლებები და ვალდებულებები კლიენტთან  დადებული გარიგებებით, გარდა იმ უფლებებისა და მოვალეობებისა რომლებსაც განახორციელებს SunnyGeorgia.Travel-ი, რომელსაც იღებს აღნიშნული ხელშეკრულების პირობებით  თავისი სახელითა და ტურ_ოპერატორის ხარჯზე ან/და  ტურ_ოპერატორის სახელითა და ხარჯზე.</p>
                            <p>3.1.13. SunnyGeorgia.Travel-ის მიერ აღნიშნული ხელშეკრულების შესრულების ცალმხრივად მოშლის შემთხვევაში, არ დაარღვიოს მოცემული ხელშეკრულების მე-7 მუხლში გაწერილი „საიტის საინფორმაციო უსაფრთხოების და საიტზე განთავსებული მასალების ტურ_ოპერატორის მიერ გამოყენების წესები“</p>


                            <p>3.2. ტურ_ოპერატორს უფლება აქვს:</p>
                            <p>3.2.1. მიმართოს SunnyGeorgia.Travel-ს თხოვნით შეჩერებული (დაბლოკილი) ექაუნთის  მოქმედების აღდგენის  შესახებ, იმ შემთხვევაში, თუ ტურ_ოპერატორს აქვს საფუძველი, რომ SunnyGeorgia.Travel-ის მიერ ექაუნთი იყო უსაფუძვლოდ და / ან შეცდომით დაბლოკილი.</p>
                            <p>3.2.2. მიმართოს SunnyGeorgia.Travel-ს თხოვნით, აღადგინოს საიტზე  SunnyGeorgia.Travel-ის მიერ ადრე წაშლილი  ტურ_ოპერატორის მიერ განთავსებული მასალები,  თუ ტურ_ოპერატორს აქვს იმის საფუძველი, რომ   აღნიშული მასალები საიტზე განთავსებული იყო ხელშეკრულების ან /და მოქმედი კანომდებლობის დარღვევის გარეშე.</p>
                            <p>3.2.3 შეიტანოს ცვლილებები ტურისტული  პროდუქტის შესახებ ინფორმაციაში (თუმცა, იმის გათვალისწინებით, რომ კლიენტსა და ტურ_ოპერატორს შორის დადებული გარიგებები და კლიენტის მიერ იმ პირობებში, რომლებიც გათვალისწინებული იყო ტურისტული  პროდუქტის შესახებ ინფორმაციაში ცვლილებების შეტანამდე, ტურ_ოპერატორის მიერ უნდა განხორციელდეს იმავე პირობებით ასეთი ცვლილებების გათვალისწინების გარეშე)</p>

                            <p>3.3. SunnyGeorgia.Travel-ი ვალდებულია:</p>
                            <p>3.3.1. აღნიშნულ ხელშეკრულებაში გათვალისწინებული ვალდებულობების შესრულებისათვის, უზრუნველყოს ტურ_ოპერატორისათვის საიტზე ხელმისაწვდომობა და განიხილოს საიტზე განსათავსებლი ტურისტული   პროდუქტის შესახებ  ინფორმაციაზე განცხადებები.</p>
                            <p>3.3.2. მიაწოდოს ინფორმაცია კლიენტებს ზოგადი პირობებისა და საიტის მეშვეობით გარიგებების დადების შესახებ.</p>
                            <p>3.3.3. მას შემდეგ, რაც კლიენტი გამოთქვამს სურვილს დადოს გერიგება, (საიტის გვერდზე ღილაკი " შეკვეთის " ღილაკი " ექსკურსიის დაჯავშნა" ) აცნობოს საიტის ტექნიკური საშუალებებით ტურ_ოპერატორს,  კლიენტის   სურვილის   შესახებ დადოს გარიგება.</p>
                            <p>3.3.4 საიტის ტექნიკური საშუალებებით მიიღოს კლიენტისგან ტურ_ოპერატორის სახელით და მის ხარჯზე ტურისტული  პროდუქტის ყოველი გარიგების წინასწარი გადასახადი (ავანსი), ტურისტული პროდუქტის ღირებულების (სახელშეკრულებო საგნის საფასური) 10%-ის ოდენობით(ხელშეკრულება ითვალისწინებს ცვალებად პროცენტულ რაოდენობას) და იმოქმედოს აღნიშნული ხელშეკრულების 5.1.-5.2 პუნქტის წესის შესაბამისად.</p>
                            <p>3.3.5 კლიენტის მიერ ტურისტული  პროდუქტის წინასწარი გადახდის  (ავანსი) შემდგომ შეატყობინოს კლიენტს ტურ_ოპერატორის საკონტაქტო მონაცემები (ტელეფონი, ელექტრონული ფოსტის მისამართი)  და გადაუგზავნოს კლიენტს დოკუმენტები, როლებიც ადასტურებენ წინასწარ გადახდას, ხოლო  ტურ_ოპერატორს კი კლიენტის საკონტაქტო მონაცემები.</p>
                            <p>3.3.6. იმ შემთხვევაში, თუ კლიენტმა  ან/და  ტურ_ოპერატორმა ცალმხრივად უარი თქვეს გარიგებების შესრულებაზე – ტურ_ოპერატორის სახელით და მის ხარჯზე განახორციელოს კლიენტის მიერ ადრე გადახდილი ავანსის თანხის დაბრუნება, (გარიგებებში გათვალისწინებული პირობებით, რაოდენებებითა და წესებით) იმავე საბანკო ანგარიშზე, რომლის მეშვეობით კლიენტამა განახორციელა წინასწარი გადახდის გადახდა.</p>
                            <p>3.3.7 განიხილოს ტურ_ოპერატორის მიმართვა (აღნიშნულ ხელშეკრულებაში 3.2.1 და 3.2.2. პუნქტ. შესაბამისად) და საფუძვლის არ არესებობისას და გონივრულ ვადაში , აღადგინოს ტურ_ოპერატორის ექაუნთი და/ან ტურ_ოპერატორის საიტიდან ადრე წაშლილი მასალები.</p>

                            <p>3.4. SunnyGeorgia.Travel უფლებამოსილია:</p>
                            <p>3.4.1.  ელექტრონული კომუნიკაციის მეშვეობით  მოსთხოვოს ტურ_ოპერატორს საიდენტიფიკაციო  ნებისმიერი ინფორმაცია, რომელიც აუცილებელია აღნიშნული ხელშეკრულების შესრულებისთვის. მათ შორის: პასპორტის მონაცემები, ტურისტული  პროდუქტის დეტალური აღწერა (მათ შორის: (მაგრამ არ შემოიფარგლება) ექსკურსიის მარშრუტი, ღირებულება, კლიენტების მაქსიმალური რაოდენობა). ტურ_ოპერატორის მიერ ამ პუნქტში მითითებული მონაცემების  წარდგენაზე  უარის  შემთხვევაში SunnyGeorgia.Travel-ი უფლებამოსილია ცალმხრივად უარი თქვას აღნიშნული ხელშეკრულების შესრულებაზე (არ დაუშვას საიტზე  ტურისტული   პროდუქტების განთავსება ).</p>
                            <p>3.4.2 ტურ_ოპერატორის ტურისტული მომსახურეობის შესახებ ინფორმაციის საიტზე განთავსებამდე, უფლება აქვს ნებისმიერ დროს ( ან ასეთი ინფორმაციის განთავსების შემდეგ) აწარმოოს  მოლაპარაკებები ტურ_ოპერატორთან (მათ შორის ელექტრონული საკომუნიკაციო საშუალებების მეშვეობით გასაუბრების ფორმატში) ტურისტული  მომსახურების პირობებისა და პარამეტრების გადამოწმებისათვის.  გასაუბრების დროს,   ტურისტული მომსახურების იმ ფაქტების გამოვლინების შემთხვევაში, რომლებიც არ შეესაბამება საკანომდებლო დებულებებს ან/და  ტურისტული  პროდუქტის წარსადგენი (მასპინძელი)ქვეყნის საკანონმდებლო დებულებებს, ან/და აღნიშნული ხელშეკრულების პირობებს, SunnyGeorgia.Travel-ი უფლებამოსილია ცალმხრივად, უარი თქვას აღნიშნული ხელშეკრულების შესრულებაზე (არ დაუშვას საიტზე ტურისტული    პროდუქტების განთავსება ).</p>
                            <p>3.4.3. ნებისმიერი გზით შეცვალოს საიტის შინაარსი (მათ შორის ტურ_ოპერატორის მიერ განთავსებული ტურისტული  მომსახურების შესახებ შინაარსი) მისი დიზაინი და მისი პროგრამული დანართი.</p>
                            <p>3.4.4. ტურ_ოპერატორის თანხმობის გარეშე დროებით (ნებისმიერი ხანგრძლივობის ვადით) შეაჩეროს საიტის  ან მისი ცალკეული ნაწილების (კომპონენტები) ფუნქციონირება .</p>
                            <p>3.4.5. ტურ_ოპერატორისთვის ხელმისაწვდომი ნებისმიერი ფორმით დააწესოს დამატებითი პირობები  და შეზღუდვები ტურ_ოპერატორის მიერ  საიტის  გამოყენებისათვის; მათ შორის: გადამზიდავის  მიერ საიტზე განთავსებული ინფორმაციის შენახვის მაქსიმალური ვადა, ტურ_ოპერატორისთვის განკუთვნილი ფაილების საცავის მაქსიმალური მოცულობა.</p>
                            <p>3.4.6 ტურ_ოპერატორის  გაფრთხილების გარეშე წაშალოს საიტიდან მონაცემები, რომელიც განათავსა გადამზიდავმა (მათ შორის აღნიშნული ხელშეკრულებისა ან / და მოქმედი კანონმდებლობის დარღვევით ).</p>
                            <p>3.4.7. ტურ_ოპერატორის  გაფრთხილების გარეშე და ტურ_ოპერატორის   ზიანის ანაზღაურების გარეშე, შეაჩეროს მოქმედება (დაბლოკოს) ან გააუქმოს ტურ_ოპერატორის   აკაუნტი (მათ შორის აღნიშნული ხელშეკრულებისა ან / და მოქმედი კანონმდებლობის დარღვევით განთავსების შემთხვევაში).</p>
                            <p>3.4.8. წაშალოს ან უარი განაცხადოს ტურ_ოპერატორის  მიერ საიტზე ინფორმაცის განთავსებაზე, თუ ის  ტურ_ოპერატორის  მიერ საიტზე განთავსებულია „ინტელექტუალური საკუთრების“ შესახებ კანონმდებლობის დარღვევით.</p>

                            <h4>4. ხელშეკრულების შესრულება, გაწეული მომსახურების  მიღება-ჩაბარება.</h4>
                            <p>4.1. SunnyGeorgia.Travel-ის მომსახურეობა  თითოეული კლიენტის მიზიდვის უზრუნველყოფად, რომელიც გამოხატავს   გარიგების (გარიგებების) დადების სურვილს, ჩაითვლება ტურ_ოპერატორის მიმართ გაწეულად, თითოეულ კლიენტთან საიტის ტექნიკური საშუალებებით  გარიგების დადების შემდეგ.</p>
                            <p>4.2. თითოეული კლიენტის მიერ,  გარიგების წინასწარი გადახდის დროიდან არა უგვიანეს 24 საათისა, SunnyGeorgia.Travel-ი უგზავნის ტურ_ოპერატორს წინასწარი გადახდის შესახებ შეტყობინებას.</p>
                            <p>4.3 ტურ_ოპერატორს, რომელსაც გააჩნია SunnyGeorgia.Travel-ის აგენტის ანგარიშზე პრეტენზიები, ვალდებულია ამის შესახებ შეატყობინოს SunnyGeorgia.Travel-ს ანგარიშის  მიღების მომენტიდან 24 (ოცდაოთხი)  საათის განმოვლობაში, წინააღმდეგ შემთხვევაში, ანგარიში ჩაითვლება ტურ_ოპერატორის მიერ მიღებულად.</p>
                            <p>4.4 კლიენტის მხრიდან ცალმხრივად კონკრეტული გარიგების შესრულებაზე უარის თქმის შემთხვევაში (ტურისტული  პროდუქტის ღირებულების კლიენტის მიერ წინასწარი გადახდის ვადიდან არა უგვიანეს 10 (ათი) კალენდარული დღისა, მაგრამ ექსკურსიის დაწყებამდე არანაკლებ 7 (შვიდი)  კალენდარული დღისა), მხარეების მიერ ადრე აღიარებული მომსახურება SunnyGeorgia.Travel-ის მხრიდან არ შესრულდება, რის შესახებაც SunnyGeorgia.Travel-ი აცნობებს ტურ_ოპერატორს ელექტრონული ფოსტის ან საიტის ტექნუკური საშუალების მეშვეობით.</p>
                            <p>4.5. ტურ_ოპერატორის მხრიდან ცალმხრივად კონკრეტული გარიგების შესრულებაზე უარის თქმის შემთხვევაში, SunnyGeorgia.Travel-ის მომსახურება ჩაითვლება შესრულებულად და ექვემდებარება გადახდას, აღნიშნული ხელშეკრულების პირობების შესაბამისად.</p>

                            <h4>5. გადახდის წესი  და  სააგენტო ანაზღაურება</h4>
                            <p>5.1. SunnyGeorgia.Travel-ის მიერ გაწეული მომსახურებისათვის სააგენტო ანაზღაურება (შემდგომში-ანაზღაურება) შეადგენს ტურისტული  პროდუქტის  (გარიგების ფასი) საერთო ღირებულების 10%-ს და მისი ანაზღაურება ხორციელდება  SunnyGeorgia.Travel-ის მიერ მიღებული, ტურ_ოპერატორის სახელით და მის ხარჯზე კლიენტისგან ტურისტული პროდუქტისთვის წინასწარ გადახდილი თანხიდან გამოქვითვის გზით, რომელიც საიტის ტექნიკური საშუალებებით გადაერიცხება ტურ_ოპერატორს.  სააგენტო ანაზღაურება  მოიცავს SunnyGeorgia.Travel-ის ყველა ხარჯებს, რომელიც დაკავშირეულია ამ უკანასკნელის მიერ  აღნიშნული ხელშეკრულების შესრულებასთან.</p>
                            <p>5.1.1  სააგენტო ანაზღაურება შეიძლება გაიზარდოს, მხარეთა შეთანხმებით, რომელიც იქნება ასახული ხელშეკრულების დამატებით შეთანხმებაში, რომელიც შეადგენს ამ ხელშეკრულების განუყოფელ ნაწილს.</p>
                            <p>5.1.2 ტურისტული აგენტი (SunnyGeorgia.Travel) თავის სააგენტო ანაზღაურება აკავებს კლიენტის მიერ გადახდილი თანხიდან, და ამ ხელშეკრულების ხელმოწერისთანავე, საბანკო ანგარიშზე ურიცხავს ტურ_ოპერატორს გადასახდელ თანხას. საბანკო ანგარიშის დეტალებს ტურ_ოპერატორი უთითებს პირად კაბინეტში/ექაუნთის განყოფილებაში "გადახდის ინფორმაცია".</p>
                            <p>5.1.3 ტურ ოპერატორი თავად იხდის საკუთარ გადასახადებს ( მათ შორის დღგ-ს და კანონით გათვალისწინებულ სხვა არსებულ გადასახადებს) იმ თანხებიდან, რომელსაც იღებს თავის ანგარიშზე ტურისტული აგენტისგან (SunnyGeorgia.Travel).</p>
                            <p>5.2.  ტურისტული  პროდუქტზე   წინასწარ გადახდილ თანხას SunnyGeorgia.Travel-ი, სააგენტო ანაზღაურების გამოკლებით, ურიცხავს ტურ_ოპერატორს ყოველი თვის 1, 11 და 21 რიცხვებში, თუ ამ რიცხვებიდან რომელიმე დღე ემთხვევა უქმე დღეს გადარიცხვა მოხდება მომდევნო პირველ სამუშაო დღეს.  კონკრეტული ტურისტული მომსახურების დაწყების მინიმუმ 3 დღის შემდეგ.</p>
                            <p>5.3. კუთვნილი ანაზღაურების გამოქვითვის უფლება ხორციელდება ყველა თანხიდან, რომელიც მიღებულია  SunnyGeorgia.Travel-ს მიერ კლიენტებისგან აღნიშნული ხელშეკრულების შესაბამისად.</p>
                            <p>5.4.  SunnyGeorgia.Travel-ის მიერ, ტურ_ოპერატორისთვის გაგზავნილი   განცხადება მოთხოვნათა ჩამონათვალის  შესახებ (მათ შორის, ელექტრონული ფოსტით ან საიტის ტექნიკური საშუალებების მეშვეობით), რომლისგანაც გამომდინარეობს მხარეების  ვალდებულებები, მიიჩნევა სავალდებულოდ შესარულებულად:</p>
                            <p>5.4.1. ტურ_ოპერატორსა და კლიენტს შორის გაფორმებული კონკრეტული გარიგების ანაზღაურების მიმამართ ტურ_ოპერატორის ვალდებულებები.</p>
                            <p>5.4.2. SunnyGeorgia.Travel-ის  ვალდებულებები წინასწარი გადახდილი თანხის გადაცემის შესახებ  კლიენტსა და  ტურ_ოპერატორს შორის დადებული გარიგებიდან.</p>
                            <p>5.5.  კლიენტის მიერ ცალმხრივად კონკრეტული გარიგების შესრულებაზე უარის თქმის შემთხვევაში და  SunnyGeorgia.Travel-ის მიერ გასაწევ მომსახურებაზე უარის   დროს, (ხელშეკრულების 4.4. პუნქტის მიხედვით) SunnyGeorgia.Travel-ი,გარიგების პირობებით დადგენილ ვადაში  იღებს ვალდებულებას   ტურ_ოპერატორის სახელით და მის ხარჯზე, კლიენტის მიერ ადრე გადახდილი  წინასწარი  გადახდის თანხის  კლიენტისთვის დაბრუნებაზე. რისთვისაც ტურ_ოპერატორი 3 საბანკო დღის განმავლობაში  იღებს ვალდებულებას გადასცეს SunnyGeorgia.Travel-ს ფულადი სახსრებიდან შესაბამისი თანხა.</p>
                            <p>5.6.  კლიენტის მიერ ცალმხრივად კონკრეტული გარიგების შესრულებაზე უარის თქმის შემთხვევაში, და  SunnyGeorgia.Travel-ის მიერ გაწეული მომსახურების შეუსრულებლობის შემთხვევაში ( ხელშეკრულების 4.4. პ. შესაბამისად) SunnyGeorgia.Travel-ი იღებს ვალდებულებას 1 (ერთი ) საბანკო დღის განმავლობაში, SunnyGeorgia.Travel-ის მიერ გაწეული მომსახურების არ შესრულებულად აღიარების მომენტიდან, ტურ_ოპერატორს დაუბრუნოს მისი მომსახურების შესაბამისი ანაზღაურების თანხა.</p>
                            <p>5.7. SunnyGeorgia.Travel-ს უფლება აქვს განაცხადოს  ფულადი მოთხოვნის  უფლების  შესახებ, რომლებიც გათვალისწინებულია ხელშეკრულების  5.5. და 5.6. პუნქტებში. ამ შემთხვევაში, SunnyGeorgia.Travel-ის მიერ ტურ_ოპერატორისთვის გაგზავნილი შეგებებული   განცხადების ერთგვაროვანი მოთხოვნის ჩათვლის შესახებ (მათ შორის, ელექტრონული ფოსტით ან საიტის ტექნიკური საშუალებების მეშვეობით) მხარეების მიერ ჩაითვლება შესრულებულად, აღნიშნული ხელშეკრულების შემდეგი ვალდებულებები:</p>
                            <p>5.7.1.  SunnyGeorgia.Travel-ის  ვალდებულებები, ფულადი სახსრების დაბრუნებაზე ტურ_ოპერატორისთვის ადრე გადახდილი ანაზღაურების მოცულობით, აღნიშნული ხელშეკრულების  5.6 მუხლის შესაბამისად.</p>
                            <p>5.7.2.  ტურ_ოპერატორის ვალდებულება, SunnyGeorgia.Travel-სთვის ფულადი სახსრების  გადაცემაზე, კლიენტისთვის, კლიენტის მიერ გარიგებისთვის წინასწარ  გადახდილი თანხის  დასაბრუნებლად, აღნიშნული ხელშეკრულების  5.5 მუხლის შესაბამისად.</p>
                            <p>5.8. აღნიშნული ხელშეკრულების შესაბამისად ყველა გადასახადების გადახდა ხორციელდება  კანონმდებლობით დადგენილი წესით.</p>
                            <p>5.9 ტურ_ოპერატორი უთითებს ფასებს ტურისტულ პროდუქტებზე ეროვნულ ლარში (GEL) ქართული კანონის შესაბამისად. თუ ფასი იქნება მითითებული აშშ დოლარში (USD) აუცილებელი იქნება კონვერტაცია საქართველოს ეროვნული ბანკის კურსით და ფასი იქნება გამოქვეყნებული ამ კურსის შესაბამის ეროვნულ ლარში. კლიენს/მომხმარებელს აქვს საშუალება გადართოს ვალyუტა ლარში ან აშშ დოლარში. იმ შემთხვევაში (მაგრამ ამით არ შეიზღუდება), როდესაც საქართველოს ეროვნული ბანკის კურსი მნიშვნელოვნად განსხვავდება ტრანზაქციის განმახორციელებელი ბანკის კურსიდან, აგენტის უფლებამოსილ პირს აქვს უფლება მიუთითოს კურსი თავად. აქტუალური კურსი მითითებულია საიტის მთავარ გვერდზე ფუტერში( სარდაფში).</p>
                            <p>5.10 ყოველი გადახდა პარტნიორებთან ხორციელდება ეროვნულ ლარში (GEL) გადახდის დღეს არსებული კურსით.</p>

                            <h4>6. მხარეთა პასუხისმგებლობა</h4>
                            <p>6.1. აღნიშნულ ხელშეკრულებაში გათვალისწინებულ მოვალეობათა   შეუსრულებლობაზე ან/და მათი არაჯეროვან შესრულებაზე მხარეები  პასუხისმგებელნი არიან მოქმედი კანონმდებლობის შესაბამისად.</p>
                            <p>6.2. SunnyGeorgia.Travel-ი, ტურ_ოპერატორზე მიყენებულ ზიანს, რომელიც გამოწვეულია მის მიერ აღნიშნული ხელშეკრულების შეუსრულებლობით ან/და  მისი არაჯეროვანი შესრულებით, აანაზღაურებს  SunnyGeorgia.Travel-ის სააგენტო მომსახურების ღირებულების ფარგლებში.</p>
                            <p>6.3. SunnyGeorgia.Travel-ი არ არის პასუხისმგებელი,  საიტის ფუნქციონირების დროებით შეჩერებაზე (აღნიშნული ხელშეკრულების მუხლის . 3.4.4. შესაბამისად) და მის შედეგებზე.</p>
                            <p>6.4. SunnyGeorgia.Travel-ი არ არის პასუხისმგებელი  საიტის ფუნქციონირების თავისებურებებთან დაკავშირებით, საიტზე ტურ_ოპერატორის მიერ განთავსებული მონაცემების ამოღების ალბათობაზე და ასეთი ამოღების შედეგებზე. აგრეთვე, ტურ_ოპერატორის მიერ განთავსებული ზოგიერთი მომნაცემის შენახვის შეუძლებლობაზე, (მათ შორის კანონსაწინააღმდეგო ხასიათის მქონე, აგრეთვე რომელიც აღემატება  საიტის ტექნიკური შესაძლებლობების მოცულობას).  ტურ_ოპერატორი  ვალდებულია მის მიერ განთავდებულ მონაცემებს გაუწიოს მონიტორინგი  და საჭიროების შემთხვევაში შეცვალოს ან ხელახლა გამოაქვეყნოს მითითებული მონაცემები.</p>
                            <p>6.5. ტურ_ოპერატორი კანონით გათვალისწინებული პირობებით პასუხისმგებელია მესამე პირების წინაშე ( მათ შორის SunnyGeorgia.Travel-ი და კლიენტები). მიყენებულ ნებისმიერ ზიანზე, რომელიც გამოწვეულია საიტზე (მათ შორის აკაუნტში) ცრუ,  არასწორი მონაცემის განთვსების გზით:  ინფორმაცია, რომელიც შეიცავს მესამე პირების პატივის, ღირსებისა  და რეპუტაციის  შემლახავ მონაცემებს, ( მათ შორის SunnyGeorgia.Travel და კლიენტებს) : ინფორმაცია, რომელიც შეიცავს მესამე პირების ცილისწამებას, მუქარას. ინფორმაციას, რომელიც დაკავშირებულია  ექსტრემისტულ საქმიანობის გამოვლინებებთან. მონაცემები, რომელიც შეიცავს კომპიუტერულ ვირუსებს და სხვა კომპიუტერულ პროგრამებს, რომლებიც განკუთვნილია კერძოდ ზიანის მიყენებისთვის, არაუფლებამოსილი შეჭრა, მონაცემების საიდუმლო და უკანონო  მოხსნა ან სხვა უკანონო გზით  მონაცემების მითვისება და გამოყენება.</p>
                            <p>6.6 საიტი არის ინფორმეციის გადაცემის საშუალება და SunnyGeorgia.Travel-ი არ აგებს პასუხს ტურ_ოპერატორისა და/ან მესამე პირის წინაშე, საიტზე განთავსებული ინფორმაციის სიზუსტესა და უსაფრთხოებაზე.</p>
                            <p>6.7. SunnyGeorgia.Travel-ი ვალდებული არ არის  წარმოადგინოს ტურ_ოპერატორის   ინტერესები, კლიენტსა და ტურ_ოპერატორს   შორის უთანხმოების წამოჭრისას, რომელიც შეიძლება წამოიჭრას  აღნიშული გარიგების შესრულების ან შეუსრულებლობისას.</p>
                            <p>6.8. SunnyGeorgia.Travel-ი არ აგებს პასუხს ტურ_ოპერატორის მიერ   გარიგების შესრულებაზე, გარდა იმ შემთხვევებისა, როდესაც გარიგების ცალკე პირობების შესრულება, დაკისრებული აქვს SunnyGeorgia.Travel-ს (მოცემული ხელშეკრულების შესაბამისად).</p>

                            <h4>7. საიტის საინფორმაციო უსაფრთხოება. ტურ_ოპერატორისთვის საიტზე განთავსებული მასალების     გამოყენების პირობები.</h4>
                            <p>7.1. ტურ_ოპერატორის მიერ  SunnyGeorgia.Travel-ზე  გადაცემული ინფორმაციის სიზუსტესა და / ან აქტუალობაზე პასუხისმგებელია ტურ_ოპერატორი.</p>
                            <p>7.2. საიტის გამოყენებით, ტურ_ოპერატორი იღებს ვალდებულებას არ დაარღვიოს ან არ შეეცადოს საიტის საინფორმაციო უსაფრთხოების დარღვევას. რაც მოიცავს:</p>
                            <p>7.2.1. ხელმისაწვდომობას ნებისმიერი  ინფორმაციასთან, რომელიც არ არის განკუთვნილი ტურ_ოპერატორისთვის   გამოსაყენლად ან ექაუნთში შესვლა, რომელიც არ არის განკუთვნილი ტურ_ოპერატორისთვის.</p>
                            <p>7.2.2. საიტის სისტემის  უსაფრთხოების დაუცველობის გადამოწმების მცდელობა, სარეგისტრაციო პროცედურების და ავტორიზაციის დარღვა  SunnyGeorgia.Travel-ის ნებართვის გარეშე.</p>
                            <p>7.3. SunnyGeorgia.Travel-ი ღებულობს ყოველ ძალისხმევას იმისათვის, რომ თავიდან აიცილოს საიტის მომხმარებლების მონაცემების  არასანქცირებული სარგებლობა.</p>
                            <p>7.4. საიტზე განთავსებული ტექსტების  ყველა ექსკლუზიური უფლება (ექსკურსიების აღწერილობა, ან ნებისმიერი სხვა ტექსტური მასალები), ეკუთვნის უფლებამოსილს. თუ ტურ_ოპერატორი არ წარმოადგენს ტექსტზე უფლებამოსილს, ტურ_ოპერატორს არ აქვს უფლებამოსილი პირის ნებართვის გარეშე ნებისმიერი საშუალებებით  იმ ტექსტის გამოყენების  უფლება, რომელიც  განთავსებულია საიტზე. (მათ შორის: გადამზიდავს უფლება არ გააჩნია დააკოპიროს ტექსტი და გაავრცელოს ის; ტურ_ოპერატორს უფლება არ გააჩნია კომერციული მიზნებისთვის ისარგებლოს საიტით, აგრეთვე საიტზე განთავსებული მასალებითა და ინფორმაციით, მფლობელის წერილობითი თანხმობის გარეშე) .
                                SunnyGeorgia.Travel -ისთვის ტურ_ოპერატორის მიერ ტექსტის წარმოდგენის შემდეგ, რომელშიც აღწერილია ტურისტული  პროდუქტი, შემდგომი დამუშავებისა და საიტზე განთავსებისათვის , ტურ_ოპერატორის მიერ აღნიშნული ხელშეკრულების მიღების შემთხვევაში, იგი აძლევს თანხმობას  SunnyGeorgia.Travel-ს  წარმოდგენილი ტექსტების გადამუშავებასა და სხვა სახით დამუშავებაზე, აგრეთვე , საიტზე დამუშავებული ტექსტის განთავსებაზე; ამასთან, ტექსტების შემოქმედებითი გადამუშავებისა და სხვა სახით დამუშავების შედეგად მიღებული ტექსებზე ექსკლუზიური უფლებები ეკუთვნის SunnyGeorgia.Travel-ს. იმასთან დაკავშირებით, რომ SunnyGeorgia.Travel-ი ტურ_ოპერატორის ტექსტებს ამუშავებს საიტზე დამუშავებული ტექსტის განთავსებისათვის,  რომ მაქსიმალურად ეფექტიურად აცნობოს  კლიენტს  ტურისტული  პროდუქტის შესახებ და საბოლოოდ ტურ_ოპერატორის ტურისტული პროდუქტის ეფექტური გაყიდვებისათვის, (შესაბამისად,SunnyGeorgia.Travel-ი  არ იყენებს ტურ_ოპერატორის ტექსტებს საკუთარი მოგების და სხვა სარგებელის მისაღებად)  SunnyGeorgia.Travel-ი არ უნაზღაურებს ტურ_ოპერატორს,  ტურ_ოპერატორის ტექსტების სარგებლობასა და დამუშავებაზე.</p>
                            <p>7.5. საიტზე ექაუნთის შექმნისას,  ტურ_ოპერატორი ადასტურებს, რომ ტურ_ოპერატორის მიერ საიტზე განთავსებული ინფორმაცია (მათ შორის  საიტის სხვა მომხმარებლებთან მიმოწერის მეშვეობით ან საიტის ტექნიკური საშუალებების გამოყენების მეშვეობით), დამატებული შეტყობინებები, გახსნილია ტურ_ოპერატორის მიერ პირადად და საკუთარი ნებით. SunnyGeorgia.Travel-ს, ნებისმიერ დროს, თავისი შეხედულებისამებრ აქვს უფლება შეამოწმოს საიტზე ტურ_ოპერატორის მიერ განთავსებული ყველა ინფორმაცია, მათ შორის, ინფორმაცია, რომელიც  გაცვალეს კლიენტებმა და ტურ_ოპერატორმა საიტზე( მათ შორის საიტზე შეტყობინების გაგზავნით გზით):
                            <ul>
                                <li>საიტზე წარმოდგენილი  სერვისის  ხარისხის გაუმჯობესების, გამარტივებული გამოყენებისა და ახალი სერვისის  დამუშავების მიზნით,</li>
                                <li>SunnyGeorgia.Travel-ის უფლებების და კანონიერი ინტერესების შესაძლო დაცვის უზრუნველსაყოფად.</li>
                                <li>ტურ_ოპერატორის მიერ საიტის სარგებლობის გამოყენების პირობების გადასამოწმებლად  (მათ შორის, აღნიშნული ხელშეკრულების. 3.1.2. მუხლის  დადგენილი აკრძალვის).</li>
                            </ul>
                            <br>
                            <h4>8. სხვა პირობები</h4>
                            <p>8.1. საიტის ადმინისტრირების უფლება , საიტის ვიზუალური მხარის გაფორმების უფლება, და საიტის პროგრამული უზრუნველყოფა ეკუთვნის SunnyGeorgia.Travel-ს. ტურ_ოპერატორს არ აქვს უფლება, SunnyGeorgia.Travel-ის ნებართვის გარეშე დააკოპიროს ან სხვა საშუალებებით აღადგინოს საიტის შინაარსობრივი მხარე, მისი გაფორმება.</p>
                            <p>8.2. ტურ_ოპერატორი  გაფრთხილებულია, რომ საიტს შესაძლოა ქონდეს მესამე პირების საიტების ლინკი, რომლის შემადგენლობასა და ნდობაზე SunnyGeorgia.Travel-ი არ არის პასუხისმგებელი, ისევე როგორ  SunnyGeorgia.Travel-ი არ არის პასუხისმგებელი ამავე ლინკზე გადასვლის შედეგებზე.</p>
                            <p>8.3. ტურ_ოპერატორი  გაფრთხილებულია, რომ საიტის შესაძლებლობა ტურ_ოპერატორის ინფორმაციის განთავსებისათვის, SunnyGeorgia.Travel ვალდებულებების შესრულების მიზნით, რომელიც განსაზღვრულია აღნიშნული ხელშეკრულებით, წარმოდგენილია ისე, როგორც იყო წარმოდგენილი აღნიშნული ხელშეკრულების გაფორმების მომენტისათვის. SunnyGeorgia.Travel-ი არ არის ვალდებული (თუმცა უფლებამოსილია) შეიტანოს დიზაინში, შინაარსში  და/ან საიტის პროგრამულ უზრუნველყოფაში ნებისმიერი ცვლილებები ტურ_ოპერატორის  მოთხოვნებისა და წინადადებების მიხედვით.</p>
                            <p>8.4. SunnyGeorgia.Travel-ს აქვს უფლება შეიტანოს აღნიშნულ ხელშეკრულებაში  ნებისმიერი ცვლილება, რომელიც არ ეწინააღმდეგება კანომდებლობას.    ხელშეკრულების მიმდინარე რედაქციაში ცვლილებების შეტანისას, მიეთითება ბოლო რედაქციის თარიღი. ხელშეკრულების ახალი რედაქცია ძალაში შედის  მისი საიტზე გამოქვეყნების მომენტიდან და მოქმედებს ყველა მომხმარებელის მიმართ, რომელმაც მიიღეს წინარე რედაცქია. ხელშეკრულების მიმდინარე ვერსია ყოველთვის განთავსებულია საიტზე პირად კაბინეტში/ექაუნთში (მომხმარებლის სივრცეში). თითოეული ტურ_ოპერატორი ვალდებულია გაეცნოს და დაეთანხმოს ხელშეკრულებაში შესულ ცვლილებებს.</p>
                            <p>8.5. აღნიშნული ხელშეკრულების  8.4 პუნქტით გათვალისწინებული წესით თუ აღნიშნული ხელშეკრულების   ცვლილებების შემდეგ ტურ_ოპერატორი კვლავ აგრძელებს SunnyGeorgia.Travel-ის მომსახურეობით სარგებლობას (მათ შორის საიტის ექაუნთის გამოყენება), ტურ_ოპერატორი ითვლება დათანხმებულად SunnyGeorgia.Travel-ის მიერ ხელშეკრულების ცვლილებაზე.</p>
                            <p>8.6. ტურ_ოპერატორს და SunnyGeorgia.Travel-ს აქვთ უფლება ნებისმიერ დროს განაცხადონ უარი აღნიშნული ხელშეკრულების  შესრულებაზე მეორე მხარის გაფრთხილების შემდგომ (მათ შორის, ელექტრონული ფოსტით ან საიტის ტექნიკური საშუალებების გამოყენებით)  ხელშეკრულებით გათვალისწინებული ანგარიშწორების წინასწარი მოაგვარების შემდგომ, ამასთანავე ხელშეკრულების გაუქმების მომენტიდან ამ პუნქტში მითითებული მიზეზით გადამზიდავი  კარგავს უფლებას ისარგებლოს  ექაუნთის  საიტით.</p>
                            <p>8.7. მხარეთა შორის ურთიერთობა რეგულირდება  აღნიშნული ხელშეკრულებით და საქართველოს კანონმდებლობით.</p>
                            <p>8.8 ტურ_ოპერატორსა და SunnyGeorgia.Travel-ს (შემდგომში -მხარეები) შორის აღნიშნული ხელშეკრულებით  ან მასთან დაკავშირებით დავისა და უთანხმოების წარმოშობის შემთვევაში,  მხარეები იღებენ ვალდებულებას მოაგვარონ ისინი მოლაპარაკებების გზით.</p>
                            <p>8.9. აღნიშნული ხელშეკრულებით  ან მასთან დაკავშირებით წარმოქმნილი  ნებისმიერი დავა, უთანხმოება ან მოთხოვნები,  მათ შორის მისი შესრულება, დარღვევა, შეწყვეტისა ან გაუქმებასთან დაკავშირებით, აკრძალვა აღნიშნული ხელშეკრულებით  8.8 პუნქტით  მხარეთა დავა განიხილება მოქმედი კანმდებლობის შესაბამისად  სასამართლო წესით, SunnyGeorgia.Travel-ის ადგილმდებარეობის შესაბამისად ან ტურისტული აგენტის  მიერ მითითებულ ადგილას.</p>
                            <p>8.10.  აღნიშნული  ხელშეკრულების გაფორმების მეშვეობით  ტურ_ოპერატორი  იძლევა თანხმობას  თავისი პერსონალური მონაცემების დამუშავების შესახებ და მის მიმართ განხორციელებულ შემდეგ მოქმედებებზე:  შეკრება, სისტემატიზაცია, დაგროვება, შენახვა, დაზუსტება (განახლება, შეცვლა) სარგებლობა, გავრცელება, დაბლოკვა, პირადი მონაცემების განადგურება, აგრეთვე მესამე პირებისთვის ისეთი ინფორმაციის გადაცემა, რომლის გადაცემაც არ არის აკრძალული  მოქმედი კანომდებლობის შესაბამისად. აღნიშნული თანხმობა შეიძლება იყოს ნებისმიერ დროს გამოთხოვნილი ტურ_ოპერატორის მიერ SunnyGeorgia.Travel-ისათვის წერილობითი განცხადების გაგზავნის გზით. ტურ_ოპერატორის მიერ თანხმობის გამოთხოვნის შემთხვევაში, ტურ_ოპერატორი ვალდებულია, გამოთხოვის თარიღიდან არ ისარგებლოს საიტის ფუნქციებით და სერვერით. ხოლო SunnyGeorgia.Travel-ი უფლებამოსილია,  ტურ_ოპერატორის  თანხმობის გამოთხოვის შესახებ წერილობითი განცხადების მიღების თარიღიდან დაბლოკოს ტურ_ოპერატორის ექაუნთი.</p>
                            <p>8.11. აღნიშნული ხელშეკრულების გაფორმების მომენტად ითვლება ტურ_ოპერატორის მიერ ექაუნთის შექმნა. აღნიშნული ხელშეკრულების გაფორმების შემთხვევაში ტურ_ოპერატორი ადასტურებს თავის ასაკს (არანაკლებ 18 წლისა)  და თავის თანხმობას აღნიშნული ხელშეკრულების ყველა პირობებზე.</p>
                            <p>8.12. აღნიშნული ხელშეკრულების გაფორმების ადგილად ითვლება ქალაქი ბათუმი, საქართველო.</p>


                        </div>
                    </div>
                    <!--end::Portlet-->

                </div>
            </div>
        </div>
    </div>

@endsection
