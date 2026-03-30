<form method="GET" action="{{ route('search.index') }}" class="w-100">
<div class="input-group position-relative">
    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
    <input type="text"
            name="q"
            class="form-control"
            placeholder="{{__('app.search_all')}}"
            id="globalSearchInput"
            autocomplete="off"
            value="{{ request('q') }}">

    <!-- Search Suggestions Dropdown -->
    <div id="searchSuggestions" class="position-absolute bg-white border rounded shadow-lg w-100 d-none" style="top: 100%; z-index: 9999; left: 0; margin-top: 2px; min-width: 30%;">
        <div class="p-2">
            <div class="text-muted small mb-2">{{__('app.search_suggestions')}}:</div>
            <div id="suggestionsList"></div>
        </div>
    </div>
</div>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('globalSearchInput');
    const suggestionsContainer = document.getElementById('searchSuggestions');
    const suggestionsList = document.getElementById('suggestionsList');
    let searchTimeout;

    if (searchInput) {
        // Handle input changes for suggestions
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();

            clearTimeout(searchTimeout);

            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    fetchSuggestions(query);
                }, 300);
            } else {
                hideSuggestions();
            }
        });

        // Handle Enter key
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (this.value.trim()) {
                    this.closest('form').submit();
                }
            } else if (e.key === 'Escape') {
                hideSuggestions();
            }
        });

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                hideSuggestions();
            }
        });
    }

    function fetchSuggestions(query) {

        fetch(`{{ route('search.suggestions') }}?q=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(suggestions => {
                displaySuggestions(suggestions, query);
            })
            .catch(error => {
                console.error('Error fetching suggestions:', error);
                hideSuggestions();
            });
    }

    function displaySuggestions(suggestions, query) {

        if (!suggestions || suggestions.length === 0) {
            hideSuggestions();
            return;
        }

        suggestionsList.innerHTML = suggestions.map(suggestion =>
            `<div class="suggestion-item p-2 rounded cursor-pointer hover-bg-light" onclick="selectSuggestion('${suggestion.replace(/'/g, "\\'")}')">
                <i class="fas fa-search me-2 text-muted"></i>
                ${suggestion}
            </div>`
        ).join('');

        suggestionsContainer.classList.remove('d-none');

    }

    function hideSuggestions() {
        suggestionsContainer.classList.add('d-none');
    }

    window.selectSuggestion = function(suggestion) {
        searchInput.value = suggestion;
        hideSuggestions();
        searchInput.closest('form').submit();
    };
});
</script>

<style>
#searchSuggestions {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #dee2e6 !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.suggestion-item {
    transition: background-color 0.2s ease;
    cursor: pointer;
}

.suggestion-item:hover {
    background-color: #f8f9fa !important;
}

.cursor-pointer {
    cursor: pointer;
}

/* Force visibility when not hidden */
#searchSuggestions:not(.d-none) {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
}
</style>