## Introduction
This is another project I made in year 2014 when I was first learning how to do asynchronous JavaScript calls.

This project was inspired by a word and mind game with the same name in Eat Bulaga (GMA 7), but this version is played through typing in a keyboard.

<br>

## Environment
Due to bandwidth and timing issues, this application is only meant to be used in a local network with one computer acting as a server.

No big deal with security and use cases, just for fun!

<br>

## Mechanics
There are three main users of this application:
<table>
    <thead>
        <tr>
            <td></td>
            <td>USER</td>
            <td>ROUTE</td>
            <td>DESCRIPTION</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1.</td>
            <td>HOST</td>
            <td><code>/set</code></td>
            <td>Sets the name of the 2 players, word to guess, and time limit.</td>
        </tr>
        <tr>
            <td>2.</td>
            <td>Player 1: Asker<br><small>(Tagatanong)</small></td>
            <td><code>/ask</code></td>
            <td>The player who will guess the word set by the host by asking yes/no questions.</td>
        </tr>
        <tr>
            <td>3.</td>
            <td>Player 2: Answerer<br><small>(Tagasagot)</small></td>
            <td><code>/ans</code></td>
            <td>The player who sees the word set by the host, and will help Player 1 to guess the word by answering "Oo" (Yes) or "Hindi" (no) to the questions.</td>
        </tr>
    </tbody>
</table>
All user interactions are done through typing.

For Player 2, hotkeys are available to quickly answer the questions:
<ul>
    <li><code>O</code> - Oo (Yes)</li>
    <li><code>H</code> - Hindi (No)</li>
</ul>

The timer set by the host will automatically stop when Player 1 successfully typed the correct word, or when the time limit is reached.
The word will be revealed when Player 1 failed to guess it correctly.

The conversation between the two players will be reset when the host sets a new word.

<br>

## Installation
On the server computer, download and install `XAMPP`, then clone or download this repository to the `htdocs` folder.

Sample path: `C:\xampp\htdocs\pinoyhenyo`.


<br>

## Usage
Determine the local IP address of the server computer and use it to connect the computer for Player 1 and Player 2.

Sample URL: `http://192.168.1.1/pinoyhenyo`.

Then, access the ROUTE per player.

<i>NOTE: There were no authentication and page restrictions in place, so this game is better played with live spectators to check on the proper conduct of the game.</i>

<i>PRs are welcome to make this app more interactive using the mordern development tools.</i>
