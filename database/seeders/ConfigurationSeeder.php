<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuration;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::create([
            'schoolsInfo' => [
                'states' => ['Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','Florida','Georgia',
                'Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts',
                'Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey',
                'New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania','Rhode Island',
                'South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia','Wisconsin','Wyoming'],
                'divisions' => ['1', '2', '3'],
                'leagues' => ['NCAA', 'NAIA', 'NJCAA'],
            ],
            'sportsScholarshipsMoreInfo' => "<p>An sports scholarship is a form of scholarship to attend a college or university or a private high school awarded to an individual based predominantly on his or her ability to play in a sport. Athletic scholarships are common in the United States, but in a majority of countries they are rare or non-existent. Currently we are focused on United States schools but in future we will add schools and clubs that have same offers outside of States.</p>
            <p>United States colleges and universities are divided into different leagues (<b>NCAA</b>, <b>NAIA</b>, <b>NJCAA</b>) and divisions (1, 2, 3).</p>
            <br>
            <p class='subtitle'>What do you need to know?</p>
            <p><b>National Collegiate Athletic Association (NCAA)</b> has a four year studies and mostly require GPA over 2.5 from your highschool, SAT or ACT test with bottom scores based on the each school and TOEFL test if you are outside of United States.</p>
            <br>
            <p><b>National Association of Intercollegiate Athletics (NAIA)</b> has a four year studies and has a same requirements as NCAA.</p>
            <br>
            <p><b>National Junior College Athletic Association (NJCAA)</b> has a two year studies and doesn't require SAT or ACT tests, but if you are outside of United States you will need to pass TOEFL test. After finishing two years you can go directly to third year at some four year college or university if you pass academic requirements.</p>
            <br>
            <p><b>SAT</b> test is an entrance exam used by most colleges and universities to make admissions decisions. The SAT is a multiple-choice, pencil-and-paper test created and administered by the College Board. SAT is divided into 3 sections (Math, Evidence-Based Reading and Writing, Essay (optional)). It lasts up to 3 hours and 50 minutes if you take additional non required Essay section. Highest score is 1600. You can apply for SAT test with <a href='https://collegereadiness.collegeboard.org/sat/register' target='_blank'>College Board</a>.</p>
            <br>
            <p><b>ACT</b> test is an entrance exam used by most colleges and universities to make admissions decisions. It is a multiple-choice, pencil-and-paper test administered by ACT, Inc. ACT is divided into five sections (English, Math, Reading, Science, Writing (optional)). It lasts up to 2 hours and 55 minutes plus 40 minutes if taking non required Writing section. Highest score is 36. You can apply for ACT test with <a href='http://www.act.org/content/act/en/products-and-services/the-act/registration.html' target='_blank'>ACT</a>, Inc.</p>
            <br>
            <p><b>TOEFL</b> test is a standardized test to measure the English language ability of non-native speakers wishing to enroll in English-speaking universities. The test is accepted by many English-speaking academic and professional institutions. TOEFL is divided into four sections (Reading, Listening, Speaking, Writing). It takes up to 3 hours and you can have 10 minutes break between Listening and Speaking. Highest score is 120 but to pass you need at least 60. You can apply for TOEFL test with <a href='https://www.ets.org/toefl/test-takers/ibt/take/register' target='_blank'>ETS</a>.</p>
            <br>
            <p class='subtitle'>If you are outside of United States</p>
            <p><b>I-20</b> is a document issued to accepted students by Student and Exchange Visitor Program (SEVP)-certified schools that indicates a student's primary purpose for coming to the United States. A student visa is a travel document you receive from a U.S. consulate or embassy before entering the United States.</p>
            <br>
            <p class='subtitle has-text-centered'>You are good to go!</p>",
            'legalInfo' => "<p class='title has-text-centered has-text-grey'>Terms and Conditions</p>
            <p class='has-text-centered has-text-danger'>This page is not complete</p>
            <br>
            <p>Bright Future is an online service that helps athletes present their profile to hundreds of schools coaches.</p>
            <br>
            <p>These Terms and Conditions govern your use of our service. As used in these Terms of Use, 'Bright Future service', 'our service' or 'the service' means the personalized service provided by Bright Future for presenting athletes to coaches, including all features and functionalities, recommendations and reviews, the website, and user interfaces, as well as all content and software associated with our service.</p>
            <br>
            <p class='subtitle'>1. <b>Membership</b></p>
            <p>1.1. We do not require monthly subscription or paid access to make your profile or use your profile. Once the profile is made, it will always be available on the website unless it is deactivated.</p>
            <br>
            <p class='subtitle'>2. <b>Presentation</b></p>
            <p>2.1. Presentation is only paid part of our service, but we do provide promo codes that can bypass paying process and give you amount of presentations based on the plan the code is assign to or the plan you purchase.</p>
            <br>
            <p class='subtitle'>3. <b>Billing and Cancellation</b></p>
            <p>3.1. Billing is currently unavailable due company registration process and choosing the best and the most secured online paying processor.</p>
            <p>3.2. Cancellation is not available once the payment is served.</p>
            <br>
            <p class='subtitle'>4. <b>Bright Future service</b></p>
            <p>4.1. You can be any age but it is advisable to have your parents around if you are under 18.</p>
            <br>
            <p class='subtitle'>5. <b>Security</b></p>
            <p>5.1. The member who created the Bright Future account, has a full control of Bright Future account and while updating settings or presenting actions, member must enter a password connected with that account. Unless the member shares account login credentials.</p>
            <p>5.2. You are responsible for updating and maintaining the accuracy of the information you provide to us relating to your account. We can terminate your account or place your account on hold in order to protect you, Netflix or our partners from identity theft or other fraudulent activity.</p>
            <br>
            <p class='title has-text-centered has-text-grey'>Privacy Policy Statement</p>
            <br>
            <p>This Privacy Statement explains our practices, including your choices, regarding the collection, use, and disclosure of certain information, including your personal information, by the Bright Future service.</p>
            <br>
            <p class='subtitle'>1. <b>Contacting Us</b></p>
            <p>1.1. If you have general questions about your account or how to contact customer service for assistance.</p>
            <br>
            <p class='subtitle'>2. <b>Collection of Information</b></p>
            <p>2.1. We receive and store information about you such as:</p>
            <p class='has-margin-left-1'>2.1.1. <b>Information you provide to us as Athlete:</b></p>
            <p class='has-margin-left-2'>2.1.1.1. Your full name, email address, location in (City, Country) format, gender, image, birthday date and sport.</p>
            <p class='has-margin-left-1'>2.1.1. <b>Information you provide to us as Recruiter:</b></p>
            <p class='has-margin-left-2'>2.1.1.1. Your full name, email address, image, work website and sport.</p>
            <br>
            <p class='subtitle'>3. <b>Use of Information</b></p>
            <p>3.1. <b>Athletes</b></p>
            <p class='has-margin-left-1'>We do not sell your informations, but use them as basic informations that schools and coaches we are presenting you to, need to know before offering you scholarships.</p>
            <p>3.2. <b>Recruiters</b></p>
            <p class='has-margin-left-1'>Your informations are shared with athletes if you send them a message via our service. Besides that you can choose do you want to receive email notifications if the new athletes join our community or if you own list of favorite athletes add a new video to their profiles.</p>
            <br>
            <p class='title has-text-centered has-text-grey'>Cookies Policy</p>
            <br>
            <p>At Bright Future, we believe in being clear and open about how we collect and use data related to you. This Cookie Policy applies to any Bright Future service that links to this policy or incorporates it by reference. By continuing to visit or use our Services, you are agreeing to the use of cookies and similar technologies for the purposes described in this policy.</p>
            <br>
            <p class='subtitle'>1. <b>What technologies are used?</b></p>
            <p>1.1. <b>Cookies</b></p>
            <p class='has-margin-left-1'>A cookie is a small file placed onto your device that enables Bright Future features and functionality. Any browser visiting our sites may receive cookies from us as service providers.</p>
            <p class='has-margin-left-1'>We use two types of cookies: persistent cookies and session cookies. A persistent cookie may help us recognize you as an existing user, so it’s easier to return to Bright Future or interact with our Services without signing in again. A persistent cookie stays in your browser and will be read by Bright Future when you return to one of our sites. Session cookies last only as long as the session (usually the current visit to a website or a browser session).</p>
            <p>1.2. <b>Local storage</b></p>
            <p class='has-margin-left-1'>Local storage enables a website or application to store information locally on your device(s). Local storage may be used to improve the Bright Future experience, for example, by enabling features, remembering your preferences and speeding up site functionality.</p>
            <br>
            <p class='subtitle'>2. <b>What are these technologies used for?</b></p>
            <p>2.1. <b>Authentication</b></p>
            <p class='has-margin-left-1'>We use cookies and similar technologies to recognize you when you visit our Services. If you’re signed into Bright Future, these technologies help us show you the right information and personalize your experience in line with your settings. For example, cookies enable Bright Future to identify you and verify your account.</p>",
            'creatorStory' => "<p>My name is Saša Orašanin and I am creator of this amazing online service. Let me tell you my story and then you can decide if my online service is truly as amazing as I say. Few years ago I was playing basketball and I was pretty decent at it. I decided to try myself at a higher level and go to the US to college, at the time I was only 19 years old.</p>
            <br>
            <p>Problem was I had no easy way to contact the coaches in this US colleges. I had to go from one website to another to find some coaches and contact them. There was another way, which is using sports agency who would contact coaches that they know. If a coach showed interest I would have to pay a large fee for them to connect me with that coach.</p>
            <br>
            <p>Being at that time there was no other options, I accepted and paid a lot of money. The downside of this experience for me was that the agency did not ensure the coach would provide all of the necessary things for my scholarship experience. Due to this I was unable to reach my full potential which in turn cost me my basketball career. If I had a due over to represent myself to reach hundreds of coaches for a small fee, I would have done it but there was no option like that available, so I decided to create a way for athletes to do just that. By choosing the plan that suits your needs we will get you in touch with the right people.</p>
            <br>
            <p class='subtitle has-text-centered'>With confidence we will bring you one step closer to your future career!</p>"
        ]);
    }
}
