<?php

namespace Drupal\Tests\bcbb_search\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Functional tests.
 *
 * @group BcBb
 */
class BcbbSearchFunctionalTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected $profile = 'standard';

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'bcbb_search',
  ];

  /**
   * Tests.
   */
  public function test(): void {
    $this->drupalGet('');
    $this->assertSession()->statusCodeEquals(200);

    $this->drupalGet('search/site');
    $this->assertSession()->statusCodeEquals(200);

    // Login as admin.
    $this->drupalLogin($this->rootUser);

    // Create article node.
    $this->drupalGet('node/add/article');
    $edit_article = [
      'edit-title-0-value' => 'Article Title ' . $this->randomString(),
      'edit-body-0-value' => 'Article Body ' . $this->randomString(),
    ];
    $this->submitForm($edit_article, 'Save');

    // Create page node.
    $this->drupalGet('node/add/page');
    $edit_page = [
      'edit-title-0-value' => 'Page Title ' . $this->randomString(),
      'edit-body-0-value' => 'Page Body ' . $this->randomString(),
    ];
    $this->submitForm($edit_page, 'Save');

    $this->drupalGet('admin/content');

    $this->drupalGet('search/site');
    // Article.
    $this->assertSession()->elementTextEquals('xpath', '//a[@data-drupal-facet-item-value = "article"]', 'article (1)');
    $this->assertSession()->pageTextContains($edit_article['edit-title-0-value']);
    $this->assertSession()->pageTextContains($edit_article['edit-body-0-value']);
    // Page.
    $this->assertSession()->elementTextEquals('xpath', '//a[@data-drupal-facet-item-value = "page"]', 'page (1)');
    $this->assertSession()->pageTextContains($edit_page['edit-title-0-value']);
    $this->assertSession()->pageTextContains($edit_page['edit-body-0-value']);

    // Test facet search.
    $this->clickLink('article (1)');
    $this->assertSession()->pageTextContains($edit_article['edit-title-0-value']);
    $this->assertSession()->pageTextNotContains($edit_page['edit-title-0-value']);

    // Test full text search with title.
    $edit = [
      'edit-search-api-fulltext' => 'Page Title',
    ];
    $this->submitForm($edit, 'Search');
    $this->assertSession()->pageTextNotContains($edit_article['edit-title-0-value']);
    $this->assertSession()->pageTextContains($edit_page['edit-title-0-value']);

    // Test full text search with body.
    $edit = [
      'edit-search-api-fulltext' => 'Article Body',
    ];
    $this->submitForm($edit, 'Search');
    $this->assertSession()->pageTextContains($edit_article['edit-title-0-value']);
    $this->assertSession()->pageTextNotContains($edit_page['edit-title-0-value']);
  }

}
