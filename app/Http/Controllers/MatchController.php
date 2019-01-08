<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use App\Match;

class MatchController extends Controller {

    public function index() {
        return view('index');
    }

    /**
     * Returns a list of matches
     *
     * TODO it's mocked, make this work :)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function matches() {
        $matches = Match::all();
        return response()->json($matches);
    }

    /**
     * Returns the state of a single match
     *
     * TODO it's mocked, make this work :)
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function match($id) {
        $match = Match::find($id);
        return response()->json($match);
    }

    /**
     * Makes a move in a match
     *
     * TODO it's mocked, make this work :)
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function move($id) {
        $match= Match::find($id);

        $position = Input::get('position');
        $board = $match->board;
        $board[$position] = $match->next;
        $match->board = $board;

        $match->winner = $this->isWinner($board) ? $match->next : 0;
        
        $match->next= $match->next==1 ? 2 : 1;
        
        $match->save();
        return response()->json($match);
        
    }

    /**
     * Creates a new match and returns the new list of matches
     *
     * TODO it's mocked, make this work :)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create() {

        $match = new Match;
        $match->name = "Match";
        $match->next = 1;
        $match->winner = 0;
        $match->board = [
                            0, 0, 0,
                            0, 0, 0,
                            0, 0, 0,
                        ];
        $match->save();

        $matches = Match::all();
        return response()->json($matches);
    }

    /**
     * Deletes the match and returns the new list of matches
     *
     * TODO it's mocked, make this work :)
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id) {
        $match = Match::find($id);
        $match->delete();
        $matches = Match::all();
        return response()->json($matches);
    }

    /**
    * Verify who is the winner
    * 
    * @return boolean
    */
    private function isWinner($board){
        
        for($i=0; $i<3; $i++){
            if ($this->verifyRow($board[$i], $board[$i+3], $board[$i+6])) {
                return true;
            }
        } 

        $i = 0;
        while($i<=6){
            if ($this->verifyRow($board[$i], $board[$i+1], $board[$i+2])){
                return true;
            }
            $i += 3;
        }

        if ($this->verifyRow($board[0], $board[4], $board[8])){
            return true;
        }

        if ($this->verifyRow($board[2], $board[4], $board[6])){
            return true;
        }
        
        return false;
       
    }


    /**
    * Verify if the values are equal to 1 or 2
    * 
    * @return boolean
    */
    private function verifyRow($cell1, $cell2, $cell3){
        if ($cell1==$cell2 && $cell2==$cell3){
            if ($cell1==1 || $cell1==2) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Creates a fake array of matches
     *
     * @return \Illuminate\Support\Collection
     */
    private function fakeMatches() {
        return collect([
            [
                'id' => 1,
                'name' => 'Match1',
                'next' => 2,
                'winner' => 1,
                'board' => [
                    1, 0, 2,
                    0, 1, 2,
                    0, 2, 1,
                ],
            ],
            [
                'id' => 2,
                'name' => 'Match2',
                'next' => 1,
                'winner' => 0,
                'board' => [
                    1, 0, 2,
                    0, 1, 2,
                    0, 0, 0,
                ],
            ],
            [
                'id' => 3,
                'name' => 'Match3',
                'next' => 1,
                'winner' => 0,
                'board' => [
                    1, 0, 2,
                    0, 1, 2,
                    0, 2, 0,
                ],
            ],
            [
                'id' => 4,
                'name' => 'Match4',
                'next' => 2,
                'winner' => 0,
                'board' => [
                    0, 0, 0,
                    0, 0, 0,
                    0, 0, 0,
                ],
            ],
        ]);
    }

}