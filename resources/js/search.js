import $ from "jquery";

class Search {
    // 1. describe and create/initiate our object
    constructor() {
        this.closeButton = $(".search-overlay__close, .mobile-overlay__close , body");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("input[type=search]");
        this.resultsDiv = $(".search-overlay__results");
        this.searchForm = $(".search-form");
        this.searchForm.on("submit", (event) => this.submitForm(event));
        this.events();

        this.isOverlayOpen = false;
        this.isSpinnerVisible = false;

        // this.previousValue;
        // this.typingTimer;
    }

    // 2.events
    events() {
        this.closeButton.on("click", this.closeOverlay.bind(this));
        this.searchForm.on("submit", this.submitForm.bind(this));
        this.searchField.on("keyup", this.typingLogic.bind(this));
    }


    // 3. methods (function, action...)
    typingLogic() {
        if (this.searchField.val()) {
            $(".mobile-overlay__close").removeClass('d-none');
        }
        if (this.searchField.val() != this.previousValue) {
            clearTimeout(this.typingTimer);
            if (this.searchField.val()) {
                if (!this.isSpinnerVisible) {
                    this.resultsDiv.html(`<div class="text-center mt-2"><div class="spinner-border align-baseline text-primary" role="status"></div></div>`);
                    this.isSpinnerVisible = true;

                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 750);
            } else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }
        }
        this.previousValue = this.searchField.val();
    }

    getResults() {
        $.getJSON(jsData.root_url + '/wp-json/search/v1/search?term=' + this.searchField.val(), (results) => {
            console.log(results)
            this.resultsDiv.html(`
                <div class="pt-3">
                    <div class="row g-3">
                        <!--       PRODUCT      -->
                        <div class="col-12">
                        <h5 class="mb-2">محصول</h5>
                        ${results.product.length ? '<div class="row row-cols-lg-4 row-cols-1 py-4">' : '<p class="p-2' +
                ' m-0' +
                ' border-top">هیچ محصولی یافت' +
                ' نشد</p>'}
                        ${results.product.map(item =>
                `<a class="my-2" href="${item.url}" alt="${item.title}">
                                <div class="card p-2 border-top shadow-sm my-2">
                                    <div class="row gx-2 gy-0">
                                        <div class="col-3">
                                            <div class="ratio ratio-1x1">
                                                <img src="${item.img}"
                                                     class="card-img-top"
                                                     alt="${item.title}">
                                            </div>
                                        </div>
    
                                        <div class="col">
                                            <div class="vstack h-100 py-2">
                                                <h6 class="text-primary mb-2">${item.title}</h6>
    
                                                <!-- <p class="text-primary mt-auto m-0">
                                                     ${item.price} <span class="text-secondary ms-1">تومان</span>
                                                 </p> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>`
            ).join('')}
                        ${results.product.length ? '</div>' : ''}
                        </div>
                    </div>
                </div>
            `)
            this.isSpinnerVisible = false;
        });
    }
        openOverlay() {
        this.searchField.val('');
        setTimeout(() => this.searchField.focus(), 301);
        this.isOverlayOpen = true;
        return false;
    }
    closeOverlay() {
        this.resultsDiv.html('');
        // this.searchField.val('');
        this.isOverlayOpen = false;
    }
    submitForm() {
        const searchTerm = this.searchField.val();
        if (searchTerm) {
            window.location.href = jsData.root_url + "/?s=" + searchTerm;
        }
    }

}

export default Search;