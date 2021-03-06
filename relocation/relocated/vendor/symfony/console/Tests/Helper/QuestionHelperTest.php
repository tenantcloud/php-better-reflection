<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Helper;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\InvalidArgumentException;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\MissingInputException;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ConfirmationQuestion;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Terminal;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\ApplicationTester;
/**
 * @group tty
 */
class QuestionHelperTest extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Helper\AbstractQuestionHelperTest
{
    public function testAskChoice()
    {
        $questionHelper = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $questionHelper->setHelperSet($helperSet);
        $heroes = ['Superman', 'Batman', 'Spiderman'];
        $inputStream = $this->getInputStream("\n1\n  1  \nFabien\n1\nFabien\n1\n0,2\n 0 , 2  \n\n\n");
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, '2');
        $question->setMaxAttempts(1);
        // first answer is an empty answer, we're supposed to receive the default value
        $this->assertEquals('Spiderman', $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes);
        $question->setMaxAttempts(1);
        $this->assertEquals('Batman', $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('Batman', $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes);
        $question->setErrorMessage('Input "%s" is not a superhero!');
        $question->setMaxAttempts(2);
        $this->assertEquals('Batman', $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $output = $this->createOutputInterface(), $question));
        \rewind($output->getStream());
        $stream = \stream_get_contents($output->getStream());
        $this->assertStringContainsString('Input "Fabien" is not a superhero!', $stream);
        try {
            $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, '1');
            $question->setMaxAttempts(1);
            $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $output = $this->createOutputInterface(), $question);
            $this->fail();
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Value "Fabien" is invalid', $e->getMessage());
        }
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, null);
        $question->setMaxAttempts(1);
        $question->setMultiselect(\true);
        $this->assertEquals(['Batman'], $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals(['Superman', 'Spiderman'], $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals(['Superman', 'Spiderman'], $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, '0,1');
        $question->setMaxAttempts(1);
        $question->setMultiselect(\true);
        $this->assertEquals(['Superman', 'Batman'], $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, ' 0 , 1 ');
        $question->setMaxAttempts(1);
        $question->setMultiselect(\true);
        $this->assertEquals(['Superman', 'Batman'], $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, 0);
        // We are supposed to get the default value since we are not in interactive mode
        $this->assertEquals('Superman', $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream, \true), $this->createOutputInterface(), $question));
    }
    public function testAskChoiceNonInteractive()
    {
        $questionHelper = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $questionHelper->setHelperSet($helperSet);
        $inputStream = $this->getInputStream("\n1\n  1  \nFabien\n1\nFabien\n1\n0,2\n 0 , 2  \n\n\n");
        $heroes = ['Superman', 'Batman', 'Spiderman'];
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, '0');
        $this->assertSame('Superman', $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream, \false), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, 'Batman');
        $this->assertSame('Batman', $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream, \false), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, null);
        $this->assertNull($questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream, \false), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, '0');
        $question->setValidator(null);
        $this->assertSame('Superman', $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream, \false), $this->createOutputInterface(), $question));
        try {
            $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, null);
            $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream, \false), $this->createOutputInterface(), $question);
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('Value "" is invalid', $e->getMessage());
        }
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Who are your favorite superheros?', $heroes, '0, 1');
        $question->setMultiselect(\true);
        $this->assertSame(['Superman', 'Batman'], $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream, \false), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Who are your favorite superheros?', $heroes, '0, 1');
        $question->setMultiselect(\true);
        $question->setValidator(null);
        $this->assertSame(['Superman', 'Batman'], $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream, \false), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Who are your favorite superheros?', $heroes, '0, Batman');
        $question->setMultiselect(\true);
        $this->assertSame(['Superman', 'Batman'], $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream, \false), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Who are your favorite superheros?', $heroes, null);
        $question->setMultiselect(\true);
        $this->assertNull($questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream, \false), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Who are your favorite superheros?', ['a' => 'Batman', 'b' => 'Superman'], 'a');
        $this->assertSame('a', $questionHelper->ask($this->createStreamableInputInterfaceMock('', \false), $this->createOutputInterface(), $question), 'ChoiceQuestion validator returns the key if it\'s a string');
        try {
            $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Who are your favorite superheros?', $heroes, '');
            $question->setMultiselect(\true);
            $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream, \false), $this->createOutputInterface(), $question);
        } catch (\InvalidArgumentException $e) {
            $this->assertSame('Value "" is invalid', $e->getMessage());
        }
    }
    public function testAsk()
    {
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $inputStream = $this->getInputStream("\n8AM\n");
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('What time is it?', '2PM');
        $this->assertEquals('2PM', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('What time is it?', '2PM');
        $this->assertEquals('8AM', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $output = $this->createOutputInterface(), $question));
        \rewind($output->getStream());
        $this->assertEquals('What time is it?', \stream_get_contents($output->getStream()));
    }
    public function testAskNonTrimmed()
    {
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $inputStream = $this->getInputStream(' 8AM ');
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('What time is it?', '2PM');
        $question->setTrimmable(\false);
        $this->assertEquals(' 8AM ', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $output = $this->createOutputInterface(), $question));
        \rewind($output->getStream());
        $this->assertEquals('What time is it?', \stream_get_contents($output->getStream()));
    }
    public function testAskWithAutocomplete()
    {
        if (!\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Terminal::hasSttyAvailable()) {
            $this->markTestSkipped('`stty` is required to test autocomplete functionality');
        }
        // Acm<NEWLINE>
        // Ac<BACKSPACE><BACKSPACE>s<TAB>Test<NEWLINE>
        // <NEWLINE>
        // <UP ARROW><UP ARROW><UP ARROW><NEWLINE>
        // <UP ARROW><UP ARROW><UP ARROW><UP ARROW><UP ARROW><UP ARROW><UP ARROW><TAB>Test<NEWLINE>
        // <DOWN ARROW><NEWLINE>
        // S<BACKSPACE><BACKSPACE><DOWN ARROW><DOWN ARROW><NEWLINE>
        // F00<BACKSPACE><BACKSPACE>oo<TAB><NEWLINE>
        // F⭐<TAB><BACKSPACE><BACKSPACE>⭐<TAB><NEWLINE>
        $inputStream = $this->getInputStream("Acm\nAcs\tTest\n\n\33[A\33[A\33[A\n\33[A\33[A\33[A\33[A\33[A\33[A\33[A\tTest\n\33[B\nS\33[B\33[B\nF00oo\t\nF⭐\t⭐\t\n");
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('Please select a bundle', 'FrameworkBundle');
        $question->setAutocompleterValues(['AcmeDemoBundle', 'AsseticBundle', 'SecurityBundle', 'FooBundle', 'F⭐Y']);
        $this->assertEquals('AcmeDemoBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('AsseticBundleTest', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('FrameworkBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('SecurityBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('FooBundleTest', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('AcmeDemoBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('AsseticBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('FooBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('F⭐Y', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
    }
    public function testAskWithAutocompleteTrimmable()
    {
        if (!\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Terminal::hasSttyAvailable()) {
            $this->markTestSkipped('`stty` is required to test autocomplete functionality');
        }
        // Acm<NEWLINE>
        // Ac<BACKSPACE><BACKSPACE>s<TAB>Test<NEWLINE>
        // <NEWLINE>
        // <UP ARROW><UP ARROW><NEWLINE>
        // <UP ARROW><UP ARROW><UP ARROW><UP ARROW><UP ARROW><TAB>Test<NEWLINE>
        // <DOWN ARROW><NEWLINE>
        // S<BACKSPACE><BACKSPACE><DOWN ARROW><DOWN ARROW><NEWLINE>
        // F00<BACKSPACE><BACKSPACE>oo<TAB><NEWLINE>
        $inputStream = $this->getInputStream("Acm\nAcs\tTest\n\n\33[A\33[A\n\33[A\33[A\33[A\33[A\33[A\tTest\n\33[B\nS\33[B\33[B\nF00oo\t\n");
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('Please select a bundle', 'FrameworkBundle');
        $question->setAutocompleterValues(['AcmeDemoBundle ', 'AsseticBundle', ' SecurityBundle ', 'FooBundle']);
        $question->setTrimmable(\false);
        $this->assertEquals('AcmeDemoBundle ', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('AsseticBundleTest', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('FrameworkBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals(' SecurityBundle ', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('FooBundleTest', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('AcmeDemoBundle ', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('AsseticBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('FooBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
    }
    public function testAskWithAutocompleteCallback()
    {
        if (!\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Terminal::hasSttyAvailable()) {
            $this->markTestSkipped('`stty` is required to test autocomplete functionality');
        }
        // Po<TAB>Cr<TAB>P<DOWN ARROW><DOWN ARROW><NEWLINE>
        $inputStream = $this->getInputStream("Pao\tCr\tP\33[A\33[A\n");
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('What\'s for dinner?');
        // A simple test callback - return an array containing the words the
        // user has already completed, suffixed with all known words.
        //
        // Eg: If the user inputs "Potato C", the return will be:
        //
        //     ["Potato Carrot ", "Potato Creme ", "Potato Curry ", ...]
        //
        // No effort is made to avoid irrelevant suggestions, as this is handled
        // by the autocomplete function.
        $callback = function ($input) {
            $knownWords = ['Carrot', 'Creme', 'Curry', 'Parsnip', 'Pie', 'Potato', 'Tart'];
            $inputWords = \explode(' ', $input);
            \array_pop($inputWords);
            $suggestionBase = $inputWords ? \implode(' ', $inputWords) . ' ' : '';
            return \array_map(function ($word) use($suggestionBase) {
                return $suggestionBase . $word . ' ';
            }, $knownWords);
        };
        $question->setAutocompleterCallback($callback);
        $this->assertSame('Potato Creme Pie', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
    }
    public function testAskWithAutocompleteWithNonSequentialKeys()
    {
        if (!\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Terminal::hasSttyAvailable()) {
            $this->markTestSkipped('`stty` is required to test autocomplete functionality');
        }
        // <UP ARROW><UP ARROW><NEWLINE><DOWN ARROW><DOWN ARROW><NEWLINE>
        $inputStream = $this->getInputStream("\33[A\33[A\n\33[B\33[B\n");
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $dialog->setHelperSet(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Please select a bundle', [1 => 'AcmeDemoBundle', 4 => 'AsseticBundle']);
        $question->setMaxAttempts(1);
        $this->assertEquals('AcmeDemoBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('AsseticBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
    }
    public function testAskWithAutocompleteWithExactMatch()
    {
        if (!\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Terminal::hasSttyAvailable()) {
            $this->markTestSkipped('`stty` is required to test autocomplete functionality');
        }
        $inputStream = $this->getInputStream("b\n");
        $possibleChoices = ['a' => 'berlin', 'b' => 'copenhagen', 'c' => 'amsterdam'];
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $dialog->setHelperSet(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Please select a city', $possibleChoices);
        $question->setMaxAttempts(1);
        $this->assertSame('b', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
    }
    public function getInputs()
    {
        return [
            ['$'],
            // 1 byte character
            ['¢'],
            // 2 bytes character
            ['€'],
            // 3 bytes character
            ['𐍈'],
        ];
    }
    /**
     * @dataProvider getInputs
     */
    public function testAskWithAutocompleteWithMultiByteCharacter($character)
    {
        if (!\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Terminal::hasSttyAvailable()) {
            $this->markTestSkipped('`stty` is required to test autocomplete functionality');
        }
        $inputStream = $this->getInputStream("{$character}\n");
        $possibleChoices = ['$' => '1 byte character', '¢' => '2 bytes character', '€' => '3 bytes character', '𐍈' => '4 bytes character'];
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $dialog->setHelperSet(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Please select a character', $possibleChoices);
        $question->setMaxAttempts(1);
        $this->assertSame($character, $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
    }
    public function testAutocompleteWithTrailingBackslash()
    {
        if (!\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Terminal::hasSttyAvailable()) {
            $this->markTestSkipped('`stty` is required to test autocomplete functionality');
        }
        $inputStream = $this->getInputStream('E');
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('');
        $expectedCompletion = 'ExampleNamespace\\';
        $question->setAutocompleterValues([$expectedCompletion]);
        $output = $this->createOutputInterface();
        $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $output, $question);
        $outputStream = $output->getStream();
        \rewind($outputStream);
        $actualOutput = \stream_get_contents($outputStream);
        // Shell control (esc) sequences are not so important: we only care that
        // <hl> tag is interpreted correctly and replaced
        $irrelevantEscSequences = [
            "\0337" => '',
            // Save cursor position
            "\338" => '',
            // Restore cursor position
            "\33[K" => '',
        ];
        $importantActualOutput = \strtr($actualOutput, $irrelevantEscSequences);
        // Remove colors (e.g. "\033[30m", "\033[31;41m")
        $importantActualOutput = \preg_replace('/\\033\\[\\d+(;\\d+)?m/', '', $importantActualOutput);
        $this->assertEquals($expectedCompletion, $importantActualOutput);
    }
    public function testAskHiddenResponse()
    {
        if ('\\' === \DIRECTORY_SEPARATOR) {
            $this->markTestSkipped('This test is not supported on Windows');
        }
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('What time is it?');
        $question->setHidden(\true);
        $this->assertEquals('8AM', $dialog->ask($this->createStreamableInputInterfaceMock($this->getInputStream("8AM\n")), $this->createOutputInterface(), $question));
    }
    public function testAskHiddenResponseTrimmed()
    {
        if ('\\' === \DIRECTORY_SEPARATOR) {
            $this->markTestSkipped('This test is not supported on Windows');
        }
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('What time is it?');
        $question->setHidden(\true);
        $question->setTrimmable(\false);
        $this->assertEquals(' 8AM', $dialog->ask($this->createStreamableInputInterfaceMock($this->getInputStream(' 8AM')), $this->createOutputInterface(), $question));
    }
    /**
     * @dataProvider getAskConfirmationData
     */
    public function testAskConfirmation($question, $expected, $default = \true)
    {
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $inputStream = $this->getInputStream($question . "\n");
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ConfirmationQuestion('Do you like French fries?', $default);
        $this->assertEquals($expected, $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question), 'confirmation question should ' . ($expected ? 'pass' : 'cancel'));
    }
    public function getAskConfirmationData()
    {
        return [['', \true], ['', \false, \false], ['y', \true], ['yes', \true], ['n', \false], ['no', \false]];
    }
    public function testAskConfirmationWithCustomTrueAnswer()
    {
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $inputStream = $this->getInputStream("j\ny\n");
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ConfirmationQuestion('Do you like French fries?', \false, '/^(j|y)/i');
        $this->assertTrue($dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ConfirmationQuestion('Do you like French fries?', \false, '/^(j|y)/i');
        $this->assertTrue($dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
    }
    public function testAskAndValidate()
    {
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $error = 'This is not a color!';
        $validator = function ($color) use($error) {
            if (!\in_array($color, ['white', 'black'])) {
                throw new \InvalidArgumentException($error);
            }
            return $color;
        };
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('What color was the white horse of Henry IV?', 'white');
        $question->setValidator($validator);
        $question->setMaxAttempts(2);
        $inputStream = $this->getInputStream("\nblack\n");
        $this->assertEquals('white', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('black', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        try {
            $dialog->ask($this->createStreamableInputInterfaceMock($this->getInputStream("green\nyellow\norange\n")), $this->createOutputInterface(), $question);
            $this->fail();
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals($error, $e->getMessage());
        }
    }
    /**
     * @dataProvider simpleAnswerProvider
     */
    public function testSelectChoiceFromSimpleChoices($providedAnswer, $expectedValue)
    {
        $possibleChoices = ['My environment 1', 'My environment 2', 'My environment 3'];
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Please select the environment to load', $possibleChoices);
        $question->setMaxAttempts(1);
        $answer = $dialog->ask($this->createStreamableInputInterfaceMock($this->getInputStream($providedAnswer . "\n")), $this->createOutputInterface(), $question);
        $this->assertSame($expectedValue, $answer);
    }
    public function simpleAnswerProvider()
    {
        return [[0, 'My environment 1'], [1, 'My environment 2'], [2, 'My environment 3'], ['My environment 1', 'My environment 1'], ['My environment 2', 'My environment 2'], ['My environment 3', 'My environment 3']];
    }
    /**
     * @dataProvider specialCharacterInMultipleChoice
     */
    public function testSpecialCharacterChoiceFromMultipleChoiceList($providedAnswer, $expectedValue)
    {
        $possibleChoices = ['.', 'src'];
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $inputStream = $this->getInputStream($providedAnswer . "\n");
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Please select the directory', $possibleChoices);
        $question->setMaxAttempts(1);
        $question->setMultiselect(\true);
        $answer = $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question);
        $this->assertSame($expectedValue, $answer);
    }
    public function specialCharacterInMultipleChoice()
    {
        return [['.', ['.']], ['., src', ['.', 'src']]];
    }
    /**
     * @dataProvider mixedKeysChoiceListAnswerProvider
     */
    public function testChoiceFromChoicelistWithMixedKeys($providedAnswer, $expectedValue)
    {
        $possibleChoices = ['0' => 'No environment', '1' => 'My environment 1', 'env_2' => 'My environment 2', 3 => 'My environment 3'];
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Please select the environment to load', $possibleChoices);
        $question->setMaxAttempts(1);
        $answer = $dialog->ask($this->createStreamableInputInterfaceMock($this->getInputStream($providedAnswer . "\n")), $this->createOutputInterface(), $question);
        $this->assertSame($expectedValue, $answer);
    }
    public function mixedKeysChoiceListAnswerProvider()
    {
        return [['0', '0'], ['No environment', '0'], ['1', '1'], ['env_2', 'env_2'], [3, '3'], ['My environment 1', '1']];
    }
    /**
     * @dataProvider answerProvider
     */
    public function testSelectChoiceFromChoiceList($providedAnswer, $expectedValue)
    {
        $possibleChoices = ['env_1' => 'My environment 1', 'env_2' => 'My environment', 'env_3' => 'My environment'];
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Please select the environment to load', $possibleChoices);
        $question->setMaxAttempts(1);
        $answer = $dialog->ask($this->createStreamableInputInterfaceMock($this->getInputStream($providedAnswer . "\n")), $this->createOutputInterface(), $question);
        $this->assertSame($expectedValue, $answer);
    }
    public function testAmbiguousChoiceFromChoicelist()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The provided answer is ambiguous. Value should be one of "env_2" or "env_3".');
        $possibleChoices = ['env_1' => 'My first environment', 'env_2' => 'My environment', 'env_3' => 'My environment'];
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Please select the environment to load', $possibleChoices);
        $question->setMaxAttempts(1);
        $dialog->ask($this->createStreamableInputInterfaceMock($this->getInputStream("My environment\n")), $this->createOutputInterface(), $question);
    }
    public function answerProvider()
    {
        return [['env_1', 'env_1'], ['env_2', 'env_2'], ['env_3', 'env_3'], ['My environment 1', 'env_1']];
    }
    public function testNoInteraction()
    {
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('Do you have a job?', 'not yet');
        $this->assertEquals('not yet', $dialog->ask($this->createStreamableInputInterfaceMock(null, \false), $this->createOutputInterface(), $question));
    }
    /**
     * @requires function mb_strwidth
     */
    public function testChoiceOutputFormattingQuestionForUtf8Keys()
    {
        $question = 'Lorem ipsum?';
        $possibleChoices = ['foo' => 'foo', 'żółw' => 'bar', 'łabądź' => 'baz'];
        $outputShown = [$question, '  [<info>foo   </info>] foo', '  [<info>żółw  </info>] bar', '  [<info>łabądź</info>] baz'];
        $output = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\OutputInterface::class);
        $output->method('getFormatter')->willReturn(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Formatter\OutputFormatter());
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $output->expects($this->once())->method('writeln')->with($this->equalTo($outputShown));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion($question, $possibleChoices, 'foo');
        $dialog->ask($this->createStreamableInputInterfaceMock($this->getInputStream("\n")), $output, $question);
    }
    public function testAskThrowsExceptionOnMissingInput()
    {
        $this->expectException(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\MissingInputException::class);
        $this->expectExceptionMessage('Aborted.');
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $dialog->ask($this->createStreamableInputInterfaceMock($this->getInputStream('')), $this->createOutputInterface(), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('What\'s your name?'));
    }
    public function testAskThrowsExceptionOnMissingInputForChoiceQuestion()
    {
        $this->expectException(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\MissingInputException::class);
        $this->expectExceptionMessage('Aborted.');
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $dialog->ask($this->createStreamableInputInterfaceMock($this->getInputStream('')), $this->createOutputInterface(), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Choice', ['a', 'b']));
    }
    public function testAskThrowsExceptionOnMissingInputWithValidator()
    {
        $this->expectException(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\MissingInputException::class);
        $this->expectExceptionMessage('Aborted.');
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('What\'s your name?');
        $question->setValidator(function ($value) {
            if (!$value) {
                throw new \Exception('A value is required.');
            }
        });
        $dialog->ask($this->createStreamableInputInterfaceMock($this->getInputStream('')), $this->createOutputInterface(), $question);
    }
    public function testQuestionValidatorRepeatsThePrompt()
    {
        $tries = 0;
        $application = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Application();
        $application->setAutoExit(\false);
        $application->register('question')->setCode(function ($input, $output) use(&$tries) {
            $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('This is a promptable question');
            $question->setValidator(function ($value) use(&$tries) {
                ++$tries;
                if (!$value) {
                    throw new \Exception();
                }
                return $value;
            });
            (new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper())->ask($input, $output, $question);
            return 0;
        });
        $tester = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tester\ApplicationTester($application);
        $tester->setInputs(['', 'not-empty']);
        $statusCode = $tester->run(['command' => 'question'], ['interactive' => \true]);
        $this->assertSame(2, $tries);
        $this->assertSame($statusCode, 0);
    }
    public function testEmptyChoices()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Choice question must have at least 1 choice available.');
        new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Question', [], 'irrelevant');
    }
    public function testTraversableAutocomplete()
    {
        if (!\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Terminal::hasSttyAvailable()) {
            $this->markTestSkipped('`stty` is required to test autocomplete functionality');
        }
        // Acm<NEWLINE>
        // Ac<BACKSPACE><BACKSPACE>s<TAB>Test<NEWLINE>
        // <NEWLINE>
        // <UP ARROW><UP ARROW><NEWLINE>
        // <UP ARROW><UP ARROW><UP ARROW><UP ARROW><UP ARROW><TAB>Test<NEWLINE>
        // <DOWN ARROW><NEWLINE>
        // S<BACKSPACE><BACKSPACE><DOWN ARROW><DOWN ARROW><NEWLINE>
        // F00<BACKSPACE><BACKSPACE>oo<TAB><NEWLINE>
        $inputStream = $this->getInputStream("Acm\nAcs\tTest\n\n\33[A\33[A\n\33[A\33[A\33[A\33[A\33[A\tTest\n\33[B\nS\33[B\33[B\nF00oo\t\n");
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('Please select a bundle', 'FrameworkBundle');
        $question->setAutocompleterValues(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Helper\AutocompleteValues(['irrelevant' => 'AcmeDemoBundle', 'AsseticBundle', 'SecurityBundle', 'FooBundle']));
        $this->assertEquals('AcmeDemoBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('AsseticBundleTest', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('FrameworkBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('SecurityBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('FooBundleTest', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('AcmeDemoBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('AsseticBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('FooBundle', $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
    }
    public function testDisableStty()
    {
        if (!\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Terminal::hasSttyAvailable()) {
            $this->markTestSkipped('`stty` is required to test autocomplete functionality');
        }
        $this->expectException(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid');
        \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper::disableStty();
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $dialog->setHelperSet(new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Please select a bundle', [1 => 'AcmeDemoBundle', 4 => 'AsseticBundle']);
        $question->setMaxAttempts(1);
        // <UP ARROW><UP ARROW><NEWLINE><DOWN ARROW><DOWN ARROW><NEWLINE>
        // Gives `AcmeDemoBundle` with stty
        $inputStream = $this->getInputStream("\33[A\33[A\n\33[B\33[B\n");
        try {
            $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question);
        } finally {
            $reflection = new \ReflectionProperty(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper::class, 'stty');
            $reflection->setAccessible(\true);
            $reflection->setValue(null, \true);
        }
    }
    public function testTraversableMultiselectAutocomplete()
    {
        // <NEWLINE>
        // F<TAB><NEWLINE>
        // A<3x UP ARROW><TAB>,F<TAB><NEWLINE>
        // F00<BACKSPACE><BACKSPACE>o<TAB>,A<DOWN ARROW>,<SPACE>SecurityBundle<NEWLINE>
        // Acme<TAB>,<SPACE>As<TAB><29x BACKSPACE>S<TAB><NEWLINE>
        // Ac<TAB>,As<TAB><3x BACKSPACE>d<TAB><NEWLINE>
        $inputStream = $this->getInputStream("\nF\t\nA\33[A\33[A\33[A\t,F\t\nF00o\t,A\33[B\t, SecurityBundle\nAcme\t, As\tS\t\nAc\t,As\td\t\n");
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\QuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $dialog->setHelperSet($helperSet);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('Please select a bundle (defaults to AcmeDemoBundle and AsseticBundle)', ['AcmeDemoBundle', 'AsseticBundle', 'SecurityBundle', 'FooBundle'], '0,1');
        // This tests that autocomplete works for all multiselect choices entered by the user
        $question->setMultiselect(\true);
        $this->assertEquals(['AcmeDemoBundle', 'AsseticBundle'], $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals(['FooBundle'], $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals(['AsseticBundle', 'FooBundle'], $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals(['FooBundle', 'AsseticBundle', 'SecurityBundle'], $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals(['SecurityBundle'], $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals(['AcmeDemoBundle', 'AsseticBundle'], $dialog->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
    }
    protected function getInputStream($input)
    {
        $stream = \fopen('php://memory', 'r+', \false);
        \fwrite($stream, $input);
        \rewind($stream);
        return $stream;
    }
    protected function createOutputInterface()
    {
        return new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput(\fopen('php://memory', 'r+', \false));
    }
    protected function createInputInterfaceMock($interactive = \true)
    {
        $mock = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface::class);
        $mock->expects($this->any())->method('isInteractive')->willReturn($interactive);
        return $mock;
    }
}
class AutocompleteValues implements \IteratorAggregate
{
    private $values;
    public function __construct(array $values)
    {
        $this->values = $values;
    }
    public function getIterator() : \Traversable
    {
        return new \ArrayIterator($this->values);
    }
}
