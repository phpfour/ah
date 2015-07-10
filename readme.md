## Activehire Laravel Demo

This is a demo application that was prepared for Activehire.com. Currently it has the following features:

- Laravel 5.1 
- Laravel Elixir with Bower and Gulp support
- Elasticsearch indexer with batch indexing support
- Keywords search with all standard operators
- Partial word match
- Keyword highlight in result
- Location auto-complete
- Geo-location search with flexible radius
- Search result display with result count, current range and prev/next
- Job details page

### Files

Hare are the important files:

**Command**
- app/Console/Commands/PopulateElasticsearch.php

**Controllers**
- app/Http/Controllers/SearchController.php
- app/Http/Controllers/JobController.php

**Model**
- app/Job.php
- app/Location.php

**Views**
- resources/views/home.blade.php
- resources/views/search/result.blade.php
- resources/views/job/show.blade.php

**Services**
- app/Services/Search.php

**Transformers**
- app/Transformers/TransformerInterface.php
- app/Transformers/JobTransformer.php
- app/Transformers/LocationTransformer.php

**View Presenters**
- app/Presenters/LocationPresenter.php
- app/Presenters/JobPresenter.php

**Configurations**
- config/app.php
- config/elasticsearch.php
- package.json
- bower.json
- gulpfile.js

**Frontend Assets**
- resources/assets/js/app.js
- resources/assets/less/app.less
