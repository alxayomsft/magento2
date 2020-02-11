<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Magento\Elasticsearch6\CatalogSearch\Controller\Result;

use Magento\CatalogSearch\Controller\Result\IndexTest as CatalogSearchIndexTest;
use Magento\TestModuleCatalogSearch\Model\ElasticsearchVersionChecker;
use Magento\Framework\Search\EngineResolverInterface;

/**
 * Test cases for catalog quick search using Elasticsearch 6.0+ or Elasticsearch 7.0+ search engine.
 *
 * @magentoDbIsolation disabled
 * @magentoAppIsolation enabled
 */
class IndexTest extends CatalogSearchIndexTest
{
    /**
     * Quick search test by difference product attributes.
     *
     * @magentoAppArea frontend
     * @magentoDataFixture Magento/CatalogSearch/_files/product_for_search.php
     * @magentoDataFixture Magento/CatalogSearch/_files/full_reindex.php
     * @dataProvider searchStringDataProvider
     * phpcs:disable Generic.CodeAnalysis.UselessOverridingMethod
     *
     * @param string $searchString
     * @return void
     */
    public function testExecute(string $searchString): void
    {
        $version = $this->_objectManager->get(ElasticsearchVersionChecker::class)->execute();
        $searchEngine = 'elasticsearch' . $version;
        $currentEngine = $this->_objectManager->get(EngineResolverInterface::class)->getCurrentSearchEngine();
        $this->assertEquals($searchEngine, $currentEngine);
        parent::testExecute($searchString);
    }
}
