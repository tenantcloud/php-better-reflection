<?php

namespace TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Helper;

use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\RuntimeException;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion;
use TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question;
/**
 * @group tty
 */
class SymfonyQuestionHelperTest extends \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Tests\Helper\AbstractQuestionHelperTest
{
    public function testAskChoice()
    {
        $questionHelper = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\SymfonyQuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $questionHelper->setHelperSet($helperSet);
        $heroes = ['Superman', 'Batman', 'Spiderman'];
        $inputStream = $this->getInputStream("\n1\n  1  \nFabien\n1\nFabien\n1\n0,2\n 0 , 2  \n\n\n");
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, '2');
        $question->setMaxAttempts(1);
        // first answer is an empty answer, we're supposed to receive the default value
        $this->assertEquals('Spiderman', $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $output = $this->createOutputInterface(), $question));
        $this->assertOutputContains('What is your favorite superhero? [Spiderman]', $output);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes);
        $question->setMaxAttempts(1);
        $this->assertEquals('Batman', $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $this->assertEquals('Batman', $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $this->createOutputInterface(), $question));
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes);
        $question->setErrorMessage('Input "%s" is not a superhero!');
        $question->setMaxAttempts(2);
        $this->assertEquals('Batman', $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $output = $this->createOutputInterface(), $question));
        $this->assertOutputContains('Input "Fabien" is not a superhero!', $output);
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
        $this->assertEquals(['Superman', 'Batman'], $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $output = $this->createOutputInterface(), $question));
        $this->assertOutputContains('What is your favorite superhero? [Superman, Batman]', $output);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', $heroes, ' 0 , 1 ');
        $question->setMaxAttempts(1);
        $question->setMultiselect(\true);
        $this->assertEquals(['Superman', 'Batman'], $questionHelper->ask($this->createStreamableInputInterfaceMock($inputStream), $output = $this->createOutputInterface(), $question));
        $this->assertOutputContains('What is your favorite superhero? [Superman, Batman]', $output);
    }
    public function testAskChoiceWithChoiceValueAsDefault()
    {
        $questionHelper = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\SymfonyQuestionHelper();
        $helperSet = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\HelperSet([new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\FormatterHelper()]);
        $questionHelper->setHelperSet($helperSet);
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('What is your favorite superhero?', ['Superman', 'Batman', 'Spiderman'], 'Batman');
        $question->setMaxAttempts(1);
        $this->assertSame('Batman', $questionHelper->ask($this->createStreamableInputInterfaceMock($this->getInputStream("Batman\n")), $output = $this->createOutputInterface(), $question));
        $this->assertOutputContains('What is your favorite superhero? [Batman]', $output);
    }
    public function testAskReturnsNullIfValidatorAllowsIt()
    {
        $questionHelper = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\SymfonyQuestionHelper();
        $question = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('What is your favorite superhero?');
        $question->setValidator(function ($value) {
            return $value;
        });
        $input = $this->createStreamableInputInterfaceMock($this->getInputStream("\n"));
        $this->assertNull($questionHelper->ask($input, $this->createOutputInterface(), $question));
    }
    public function testAskEscapeDefaultValue()
    {
        $helper = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\SymfonyQuestionHelper();
        $input = $this->createStreamableInputInterfaceMock($this->getInputStream('\\'));
        $helper->ask($input, $output = $this->createOutputInterface(), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('Can I have a backslash?', '\\'));
        $this->assertOutputContains('Can I have a backslash? [\\]', $output);
    }
    public function testAskEscapeAndFormatLabel()
    {
        $helper = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\SymfonyQuestionHelper();
        $input = $this->createStreamableInputInterfaceMock($this->getInputStream('TenantCloud\\BetterReflection\\Relocated\\Foo\\Bar'));
        $helper->ask($input, $output = $this->createOutputInterface(), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('Do you want to use Foo\\Bar <comment>or</comment> Foo\\Baz\\?', 'TenantCloud\\BetterReflection\\Relocated\\Foo\\Baz'));
        $this->assertOutputContains('Do you want to use Foo\\Bar or Foo\\Baz\\? [Foo\\Baz]:', $output);
    }
    public function testLabelTrailingBackslash()
    {
        $helper = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\SymfonyQuestionHelper();
        $input = $this->createStreamableInputInterfaceMock($this->getInputStream('sure'));
        $helper->ask($input, $output = $this->createOutputInterface(), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('Question with a trailing \\'));
        $this->assertOutputContains('Question with a trailing \\', $output);
    }
    public function testAskThrowsExceptionOnMissingInput()
    {
        $this->expectException(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Exception\RuntimeException::class);
        $this->expectExceptionMessage('Aborted.');
        $dialog = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\SymfonyQuestionHelper();
        $dialog->ask($this->createStreamableInputInterfaceMock($this->getInputStream('')), $this->createOutputInterface(), new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\Question('What\'s your name?'));
    }
    public function testChoiceQuestionPadding()
    {
        $choiceQuestion = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('qqq', ['foo' => 'foo', 'żółw' => 'bar', 'łabądź' => 'baz']);
        (new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\SymfonyQuestionHelper())->ask($this->createStreamableInputInterfaceMock($this->getInputStream("foo\n")), $output = $this->createOutputInterface(), $choiceQuestion);
        $this->assertOutputContains(<<<EOT
 qqq:
  [foo   ] foo
  [żółw  ] bar
  [łabądź] baz
 >
EOT
, $output, \true);
    }
    public function testChoiceQuestionCustomPrompt()
    {
        $choiceQuestion = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Question\ChoiceQuestion('qqq', ['foo']);
        $choiceQuestion->setPrompt(' >ccc> ');
        (new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Helper\SymfonyQuestionHelper())->ask($this->createStreamableInputInterfaceMock($this->getInputStream("foo\n")), $output = $this->createOutputInterface(), $choiceQuestion);
        $this->assertOutputContains(<<<EOT
 qqq:
  [0] foo
 >ccc>
EOT
, $output, \true);
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
        $output = new \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput(\fopen('php://memory', 'r+', \false));
        $output->setDecorated(\false);
        return $output;
    }
    protected function createInputInterfaceMock($interactive = \true)
    {
        $mock = $this->createMock(\TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Input\InputInterface::class);
        $mock->expects($this->any())->method('isInteractive')->willReturn($interactive);
        return $mock;
    }
    private function assertOutputContains($expected, \TenantCloud\BetterReflection\Relocated\Symfony\Component\Console\Output\StreamOutput $output, $normalize = \false)
    {
        \rewind($output->getStream());
        $stream = \stream_get_contents($output->getStream());
        if ($normalize) {
            $stream = \str_replace(\PHP_EOL, "\n", $stream);
        }
        $this->assertStringContainsString($expected, $stream);
    }
}
