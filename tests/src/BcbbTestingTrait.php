<?php

namespace Drupal\Tests\bcbb;

/**
 * Base class for tests that run on the current site.
 */
trait BcbbTestingTrait {

  /**
   * Passes if a link starting with a given href is found.
   *
   * This is proposed to be added to Drupal core:
   * https://www.drupal.org/project/drupal/issues/3360114
   *
   * @param string $href
   *   The full or partial value of the 'href' attribute of the anchor tag.
   * @param int $index
   *   Link position counting from zero.
   * @param string $message
   *   (optional) A message to display with the assertion. Do not translate
   *   messages: use \Drupal\Component\Render\FormattableMarkup to embed
   *   variables in the message text, not t(). If left blank, a default message
   *   will be displayed.
   *
   * @throws \Behat\Mink\Exception\ExpectationException
   *   Thrown when element doesn't exist.
   */
  public function linkByHrefStartsWithExists(string $href, int $index = 0, string $message = ''): void {
    $xpath = $this
      ->assertSession()->buildXPathQuery('//a[starts-with(@href, :href)]', [
        ':href' => $href,
      ]);
    $message = $message ? $message : strtr('No link with href starting with %href found.', [
      '%href' => $href,
    ]);
    $links = $this->getSession()
      ->getPage()
      ->findAll('xpath', $xpath);
    $this
      ->assertSession()->assert(!empty($links[$index]), $message);
  }

}
