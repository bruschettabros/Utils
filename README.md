## Installation

To install the package run:
```
./install.sh
```
---
## Commands

### AI

You can use a local instant of an assistant with https://lmstudio.ai/
Changing the `OPENAI_URL` in the `.env` file will change the endpoint the AI commands use.

```shell
artisan ai:interact temperature=1 --systemMessage=
```

Will start an interactive session with the AI.
 - temperature: The randomness of the AI's responses, value can be between 0 and 1
 - systemMessage: The message to instruct the assistant with

Once the chat has finished you can dump to `json` and convert to audio using `tts`

```shell
artisan ai:commit-message directory temperature=1
```

 Will generate a commit message based on the git diff of a directory
 - directory: The directory to generate the commit message for (Can be relative or absolute)
 - temperature: The randomness of the AI's responses, value can be between 0 and 1

### Audio

```shell
artisan audio:book-download {jsonFile} {name}
```
Downloads an audiobook from a json file
 - jsonFile: The json file containing the audiobook information
 - name: The name of the audiobook, used when naming files

```shell
artisan audio:merge {directory} {output}
```
Merges all audio files in a directory into a single file
 - directory: The directory containing the audio files
 - output: The output file

```shell
artisan audio:khdownload {album} {format=flac}
```
Downloads an album from [khinsider](https://downloads.khinsider.com)
 - album: The album to download (Will be the last part of the URI)
 - format: The format to download the album in (Defaults to flac)

```shell
artisan audio:tts-voices
```
Returns a list of available voices for the TTS command

```shell
audio:tts {input} {output} {--voice=en-GB-SoniaNeural}
```
Converts text to speech
 - input: The text to convert. Can be a file or a string
 - output: The output file
 - voice: The voice to use (Defaults to en-GB-SoniaNeural)

```shell
audio:tts-conversation {input} {output}
```
Will generate a conversation based on a text file. Use double new lines to switch between voice 
 - Currently the voices are hardcoded.

----
Download based commands will provide the output as a series of `wget` commands.
To run them inline pipe the output to `bash` or save them to a file and run it.

eg: 
```shell
artisan audio:khdownload super-mario-bros flac | sh
```
---
## Tests

To run the tests run: 
```shell
php artisan test --parallel
```
