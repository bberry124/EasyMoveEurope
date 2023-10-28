@extends("layouts.app")

@section("style")
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endsection

@section("content")
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
        <div class="page-header d-flex align-items-center"
            style="background-image: url('{{ asset('img/EasyMove/about us 1.jpg') }}');">
            <div class="container position-relative">
                <div class="row d-flex justify-content-center">
                    <div class="text-center">
                        <h2 class="mt-5">{{__('Privacy and Condition')}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about pt-5">
        <div class="container" data-aos="fade-up">

            <div class="row gy-4">
                <div class="content order-last  order-lg-first">
                    <div class="container" data-aos="fade-up">
                        <h2 class="privacy-title">{{__('Terms and Conditions')}}</h2>
                        <p class="privacy-text">
                            {{__('Our terms and conditions are not intended to hide information or take advantage of any situation. We only aim to be fair to all parties involved. Firstly with the customer who is paying for a quality service to be done, secondly, be fair with our partners, carriers and drivers who have transportation as a means of livelihood and with our team that aims to make a profit, but without harming anyone, very on the contrary.')}}
                        </p>
                    </div>
                </div>
                <div class="content order-last  order-lg-first">
                    <div class="container" data-aos="fade-up">
                        <h2 class="privacy-title">{{__('General terms')}}</h2>
                        <p class="privacy-text">
                            {{__('When booking the Van delivery service, the customer agrees for the shipment to be available,properly packed and secured for transportation at the pick-up address for the carrier to collect it from 8:00 to 18:00 or another hours agreed previous with Easy Move team. The selected carrier will contact the customer upon its arrival at the pick-up address. On a rare occasion, due to unforeseen factors related to the selected carrier, pick-up can be performed before or after the scheduled date.')}}
                            <br /><br />
                            {{__('If the van/driver of the selected carrier will not show up on the scheduled pick-up date or is not providing the services like help to load/unload, the customer assumes the responsibility of informing Easy Move immediately about this fact, so that Easy Move can check the situation with the carrier and fix the issue as soon as possible.')}}
                            <br /><br />
                            {{__('The customer is always able to get information about the transit of the shipment by contacting Easy Move support team, which will check the latest transit updates directly with the carrier.')}}
                            <br /><br />
                            {{__('The customer shall be informed about the estimated time of delivery in advance. If the consignee is not available at the delivery address, the driver will wait at the address until the customer can organize the unloading of the shipment, as agreed. The customer is aware that any unnecessary waiting by the driver may result in additional costs that shall be borne by the customer.')}}
                        </p>
                    </div>
                </div>
                <div class="content order-last  order-lg-first">
                    <div class="container" data-aos="fade-up">
                        <h2 class="privacy-title">{{__('Cancellation and Refund')}}</h2>
                        <p class="privacy-text">
                            {{__('When the customer places the order, at Easy Move we start the preparation for the transport and make a commitment with the carrier that will carry out the transport, which in turn reserves a van and a driver for the transport. Any cancellation of this commitment incurs costs for the carrier and automatically transfers these costs to Easy Move, so the customer can cancel but the amount of the refund will depend on when the cancellation is made.')}}
                            <br /><br />
                            {{__('Cancellation up to 48 hours before the collection date - 10% fee on the amount paid.')}}<br />
                            Cancellation less than 48 hours before collection - 30% fee on the amount paid.')}}<br />
                            {{__('After collection of the cargo, no refund is possible.')}}
                        </p>
                    </div>
                </div>
                <div class="content order-last  order-lg-first">
                    <div class="container" data-aos="fade-up">
                        <h2 class="privacy-title">{{__('Help to Load/Unload')}}</h2>
                        <p class="privacy-text">
                            {{__('The driver is not obliged to help load or unload the load. If the customer needs assistance,it needs to be contracted directly with Easy Move.')}}
                            <br />
                            {{__('Loading and/or unloading assistance will be provided from the ground floor to the van and from the van to the ground floor, for items not heavier than 20 kilos. Throughout the process, the customer must help or hire third parties to help without exception.')}}
                            <br />
                            {{__('For help loading or unloading in/from apartments, the customer needs to give advance notice and is subject to approval, as not all drivers can make physical effort and the Easy Move team needs to choose the driver in advance so that he can perform such work.')}}
                        </p>
                    </div>
                </div>
                <div class="content order-last  order-lg-first">
                    <div class="container" data-aos="fade-up">
                        <h2 class="privacy-title">{{__('About Insurance')}}</h2>
                        <p class="privacy-text">
                            {{__('Every shipment with our dedicated van delivery is covered by CMR conventions and extended liability is also available (for commercial shipments). The value is currently around 10 euros per kilo and apply to occurrence of theft, damaged goods, gross negligence in
                            international and domestic transport.')}}
                            <br />
                            {{__('Please note that any damage to the cargo caused by negligence in the packaging of the cargo,as evidenced by photos or videos, is subject to forfeiture of the right to pay the insurance.')}}
                        </p>
                    </div>
                </div>
                <div class="content order-last  order-lg-first">
                    <div class="container" data-aos="fade-up">
                        <h2 class="privacy-title">{{__('Types of vans and measurements')}}</h2>
                        <p class="privacy-text">
                            {{__('The size on the description is an average, sizes may vary. We will always try to maintain the capacity contracted by you (13 and 19 cubic meters), so it is important that the client provide us with as much information as possible about your cargo so that we can send you the appropriate van.')}}
                        </p>
                    </div>
                </div>
                <div class="content order-last  order-lg-first">
                    <div class="container" data-aos="fade-up">
                        <h2 class="privacy-title">{{__('Data protection')}}</h2>
                        <p class="privacy-text">
                            {{__('Easy Move is committed to treating all data in accordance with international data protection laws, based on the following principles:')}}
                            <br /><br />
                            - {{__('Purpose limitation.')}}
                            <br />
                            - {{__('Data minimisation.')}}
                            <br />
                            - {{__('Accuracy.')}}
                            <br />
                            - {{__('Storage limitation.')}}
                            <br />
                            - {{__('Integrity and confidentiality (security)')}}
                            <br />
                            - {{__('Accountability.')}}
                            <br />
                        </p>
                    </div>
                </div>
                <div class="content order-last  order-lg-first">
                    <div class="container" data-aos="fade-up">
                        <p class="privacy-text privacy-last-text">
                            <br /><br />
                            {{__('Any doubts or requests for data deletion can be requested from the Easy Move team at any time.Lawfulness, fairness and transparency.')}}
                            <br />
                            {{__('For any question, please contact us:')}} <a href="/contact">info@easymoveeurope.com</a>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End About Us Section -->
</main>
<!-- End #main -->
@endsection