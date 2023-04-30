package main

import (
	"encoding/json"
	"github.com/jinzhu/gorm"
	"log"
	//"encoding/json"
	"fmt"
	"io/ioutil"
	"net/http"
	"strconv"
	"strings"

	_ "github.com/jinzhu/gorm/dialects/postgres"
)

type SummonerData struct {
	ID            string `json:"id"`
	AccountID     string `json:"accountId"`
	Puuid         string `json:"puuid"`
	Name          string `json:"name"`
	ProfileIconID int    `json:"profileIconId"`
	RevisionDate  int64  `json:"revisionDate"`
	SummonerLevel int    `json:"summonerLevel"`
}

type LeagueOfLegendsMatch struct {
	GameID                int64                   `json:"gameId"`
	PlatformID            string                  `json:"platformId"`
	GameCreation          int64                   `json:"gameCreation"`
	GameDuration          int                     `json:"gameDuration"`
	QueueID               int                     `json:"queueId"`
	MapID                 int                     `json:"mapId"`
	SeasonID              int                     `json:"seasonId"`
	GameVersion           string                  `json:"gameVersion"`
	GameMode              string                  `json:"gameMode"`
	GameType              string                  `json:"gameType"`
	Teams                 []Teams                 `json:"teams"`
	Participants          []Participants          `json:"participants"`
	ParticipantIdentities []ParticipantIdentities `json:"participantIdentities"`
}

type Bans struct {
	ChampionID int `json:"championId"`
	PickTurn   int `json:"pickTurn"`
}

type Teams struct {
	TeamID               int    `json:"teamId"`
	Win                  string `json:"win"`
	FirstBlood           bool   `json:"firstBlood"`
	FirstTower           bool   `json:"firstTower"`
	FirstInhibitor       bool   `json:"firstInhibitor"`
	FirstBaron           bool   `json:"firstBaron"`
	FirstDragon          bool   `json:"firstDragon"`
	FirstRiftHerald      bool   `json:"firstRiftHerald"`
	TowerKills           int    `json:"towerKills"`
	InhibitorKills       int    `json:"inhibitorKills"`
	BaronKills           int    `json:"baronKills"`
	DragonKills          int    `json:"dragonKills"`
	VilemawKills         int    `json:"vilemawKills"`
	RiftHeraldKills      int    `json:"riftHeraldKills"`
	DominionVictoryScore int    `json:"dominionVictoryScore"`
	Bans                 []Bans `json:"bans"`
}

type Stats struct {
	ParticipantID                   int  `json:"participantId"`
	Win                             bool `json:"win"`
	Item0                           int  `json:"item0"`
	Item1                           int  `json:"item1"`
	Item2                           int  `json:"item2"`
	Item3                           int  `json:"item3"`
	Item4                           int  `json:"item4"`
	Item5                           int  `json:"item5"`
	Item6                           int  `json:"item6"`
	Kills                           int  `json:"kills"`
	Deaths                          int  `json:"deaths"`
	Assists                         int  `json:"assists"`
	LargestKillingSpree             int  `json:"largestKillingSpree"`
	LargestMultiKill                int  `json:"largestMultiKill"`
	KillingSprees                   int  `json:"killingSprees"`
	LongestTimeSpentLiving          int  `json:"longestTimeSpentLiving"`
	DoubleKills                     int  `json:"doubleKills"`
	TripleKills                     int  `json:"tripleKills"`
	QuadraKills                     int  `json:"quadraKills"`
	PentaKills                      int  `json:"pentaKills"`
	UnrealKills                     int  `json:"unrealKills"`
	TotalDamageDealt                int  `json:"totalDamageDealt"`
	MagicDamageDealt                int  `json:"magicDamageDealt"`
	PhysicalDamageDealt             int  `json:"physicalDamageDealt"`
	TrueDamageDealt                 int  `json:"trueDamageDealt"`
	LargestCriticalStrike           int  `json:"largestCriticalStrike"`
	TotalDamageDealtToChampions     int  `json:"totalDamageDealtToChampions"`
	MagicDamageDealtToChampions     int  `json:"magicDamageDealtToChampions"`
	PhysicalDamageDealtToChampions  int  `json:"physicalDamageDealtToChampions"`
	TrueDamageDealtToChampions      int  `json:"trueDamageDealtToChampions"`
	TotalHeal                       int  `json:"totalHeal"`
	TotalUnitsHealed                int  `json:"totalUnitsHealed"`
	DamageSelfMitigated             int  `json:"damageSelfMitigated"`
	DamageDealtToObjectives         int  `json:"damageDealtToObjectives"`
	DamageDealtToTurrets            int  `json:"damageDealtToTurrets"`
	VisionScore                     int  `json:"visionScore"`
	TimeCCingOthers                 int  `json:"timeCCingOthers"`
	TotalDamageTaken                int  `json:"totalDamageTaken"`
	MagicalDamageTaken              int  `json:"magicalDamageTaken"`
	PhysicalDamageTaken             int  `json:"physicalDamageTaken"`
	TrueDamageTaken                 int  `json:"trueDamageTaken"`
	GoldEarned                      int  `json:"goldEarned"`
	GoldSpent                       int  `json:"goldSpent"`
	TurretKills                     int  `json:"turretKills"`
	InhibitorKills                  int  `json:"inhibitorKills"`
	TotalMinionsKilled              int  `json:"totalMinionsKilled"`
	NeutralMinionsKilled            int  `json:"neutralMinionsKilled"`
	NeutralMinionsKilledTeamJungle  int  `json:"neutralMinionsKilledTeamJungle"`
	NeutralMinionsKilledEnemyJungle int  `json:"neutralMinionsKilledEnemyJungle"`
	TotalTimeCrowdControlDealt      int  `json:"totalTimeCrowdControlDealt"`
	ChampLevel                      int  `json:"champLevel"`
	VisionWardsBoughtInGame         int  `json:"visionWardsBoughtInGame"`
	SightWardsBoughtInGame          int  `json:"sightWardsBoughtInGame"`
	WardsPlaced                     int  `json:"wardsPlaced"`
	WardsKilled                     int  `json:"wardsKilled"`
	FirstBloodKill                  bool `json:"firstBloodKill"`
	FirstBloodAssist                bool `json:"firstBloodAssist"`
	FirstTowerKill                  bool `json:"firstTowerKill"`
	FirstTowerAssist                bool `json:"firstTowerAssist"`
	FirstInhibitorKill              bool `json:"firstInhibitorKill"`
	FirstInhibitorAssist            bool `json:"firstInhibitorAssist"`
	CombatPlayerScore               int  `json:"combatPlayerScore"`
	ObjectivePlayerScore            int  `json:"objectivePlayerScore"`
	TotalPlayerScore                int  `json:"totalPlayerScore"`
	TotalScoreRank                  int  `json:"totalScoreRank"`
	PlayerScore0                    int  `json:"playerScore0"`
	PlayerScore1                    int  `json:"playerScore1"`
	PlayerScore2                    int  `json:"playerScore2"`
	PlayerScore3                    int  `json:"playerScore3"`
	PlayerScore4                    int  `json:"playerScore4"`
	PlayerScore5                    int  `json:"playerScore5"`
	PlayerScore6                    int  `json:"playerScore6"`
	PlayerScore7                    int  `json:"playerScore7"`
	PlayerScore8                    int  `json:"playerScore8"`
	PlayerScore9                    int  `json:"playerScore9"`
	Perk0                           int  `json:"perk0"`
	Perk0Var1                       int  `json:"perk0Var1"`
	Perk0Var2                       int  `json:"perk0Var2"`
	Perk0Var3                       int  `json:"perk0Var3"`
	Perk1                           int  `json:"perk1"`
	Perk1Var1                       int  `json:"perk1Var1"`
	Perk1Var2                       int  `json:"perk1Var2"`
	Perk1Var3                       int  `json:"perk1Var3"`
	Perk2                           int  `json:"perk2"`
	Perk2Var1                       int  `json:"perk2Var1"`
	Perk2Var2                       int  `json:"perk2Var2"`
	Perk2Var3                       int  `json:"perk2Var3"`
	Perk3                           int  `json:"perk3"`
	Perk3Var1                       int  `json:"perk3Var1"`
	Perk3Var2                       int  `json:"perk3Var2"`
	Perk3Var3                       int  `json:"perk3Var3"`
	Perk4                           int  `json:"perk4"`
	Perk4Var1                       int  `json:"perk4Var1"`
	Perk4Var2                       int  `json:"perk4Var2"`
	Perk4Var3                       int  `json:"perk4Var3"`
	Perk5                           int  `json:"perk5"`
	Perk5Var1                       int  `json:"perk5Var1"`
	Perk5Var2                       int  `json:"perk5Var2"`
	Perk5Var3                       int  `json:"perk5Var3"`
	PerkPrimaryStyle                int  `json:"perkPrimaryStyle"`
	PerkSubStyle                    int  `json:"perkSubStyle"`
	StatPerk0                       int  `json:"statPerk0"`
	StatPerk1                       int  `json:"statPerk1"`
	StatPerk2                       int  `json:"statPerk2"`
}

type CreepsPerMinDeltas struct {
	One020 float64 `json:"10-20"`
	Zero10 float64 `json:"0-10"`
}

type XpPerMinDeltas struct {
	One020 float64 `json:"10-20"`
	Zero10 float64 `json:"0-10"`
}

type GoldPerMinDeltas struct {
	One020 float64 `json:"10-20"`
	Zero10 float64 `json:"0-10"`
}

type CsDiffPerMinDeltas struct {
	One020 float64 `json:"10-20"`
	Zero10 float64 `json:"0-10"`
}

type XpDiffPerMinDeltas struct {
	One020 float64 `json:"10-20"`
	Zero10 int     `json:"0-10"`
}

type DamageTakenPerMinDeltas struct {
	One020 float64 `json:"10-20"`
	Zero10 float64 `json:"0-10"`
}

type DamageTakenDiffPerMinDeltas struct {
	One020 float64 `json:"10-20"`
	Zero10 float64 `json:"0-10"`
}

type Timeline struct {
	ParticipantID               int                         `json:"participantId"`
	CreepsPerMinDeltas          CreepsPerMinDeltas          `json:"creepsPerMinDeltas"`
	XpPerMinDeltas              XpPerMinDeltas              `json:"xpPerMinDeltas"`
	GoldPerMinDeltas            GoldPerMinDeltas            `json:"goldPerMinDeltas"`
	CsDiffPerMinDeltas          CsDiffPerMinDeltas          `json:"csDiffPerMinDeltas"`
	XpDiffPerMinDeltas          XpDiffPerMinDeltas          `json:"xpDiffPerMinDeltas"`
	DamageTakenPerMinDeltas     DamageTakenPerMinDeltas     `json:"damageTakenPerMinDeltas"`
	DamageTakenDiffPerMinDeltas DamageTakenDiffPerMinDeltas `json:"damageTakenDiffPerMinDeltas"`
	Role                        string                      `json:"role"`
	Lane                        string                      `json:"lane"`
}

type Participants struct {
	ParticipantID int      `json:"participantId"`
	TeamID        int      `json:"teamId"`
	ChampionID    int      `json:"championId"`
	Spell1ID      int      `json:"spell1Id"`
	Spell2ID      int      `json:"spell2Id"`
	Stats         Stats    `json:"stats"`
	Timeline      Timeline `json:"timeline"`
}

type Player struct {
	PlatformID        string `json:"platformId"`
	AccountID         string `json:"accountId"`
	SummonerName      string `json:"summonerName"`
	SummonerID        string `json:"summonerId"`
	CurrentPlatformID string `json:"currentPlatformId"`
	CurrentAccountID  string `json:"currentAccountId"`
	MatchHistoryURI   string `json:"matchHistoryUri"`
	ProfileIcon       int    `json:"profileIcon"`
}

type ParticipantIdentities struct {
	ParticipantID int    `json:"participantId"`
	Player        Player `json:"player"`
}


type SummonerActiveMatch struct {
	GameID            int64  `json:"gameId"`
	MapID             int    `json:"mapId"`
	GameMode          string `json:"gameMode"`
	GameType          string `json:"gameType"`
	GameQueueConfigID int    `json:"gameQueueConfigId"`
	Participants      []struct {
		TeamID                   int           `json:"teamId"`
		Spell1ID                 int           `json:"spell1Id"`
		Spell2ID                 int           `json:"spell2Id"`
		ChampionID               int           `json:"championId"`
		ProfileIconID            int           `json:"profileIconId"`
		SummonerName             string        `json:"summonerName"`
		Bot                      bool          `json:"bot"`
		SummonerID               string        `json:"summonerId"`
		GameCustomizationObjects []interface{} `json:"gameCustomizationObjects"`
		Perks                    struct {
			PerkIds      []int `json:"perkIds"`
			PerkStyle    int   `json:"perkStyle"`
			PerkSubStyle int   `json:"perkSubStyle"`
		} `json:"perks"`
	} `json:"participants"`
	Observers struct {
		EncryptionKey string `json:"encryptionKey"`
	} `json:"observers"`
	PlatformID      string `json:"platformId"`
	BannedChampions []struct {
		ChampionID int `json:"championId"`
		TeamID     int `json:"teamId"`
		PickTurn   int `json:"pickTurn"`
	} `json:"bannedChampions"`
	GameStartTime int64 `json:"gameStartTime"`
	GameLength    int   `json:"gameLength"`
}

type ParticipantFrameStat struct {
	ParticipantID int `json:"participantId"`
	Position      struct {
		X int `json:"x"`
		Y int `json:"y"`
	} `json:"position"`
	CurrentGold         int `json:"currentGold"`
	TotalGold           int `json:"totalGold"`
	Level               int `json:"level"`
	Xp                  int `json:"xp"`
	MinionsKilled       int `json:"minionsKilled"`
	JungleMinionsKilled int `json:"jungleMinionsKilled"`
	DominionScore       int `json:"dominionScore"`
	TeamScore           int `json:"teamScore"`
}
type MatchTimeline struct {
	Frames  []struct {
		ParticipantFrames []ParticipantFrameStat  `json:"participantFrames"`
		Events    []LeagueOfLegendsEvent`json:"events"`
		Timestamp int           `json:"timestamp"`
	} `json:"frames"`
	FrameInterval int `json:"frameInterval"`
}

type LeagueOfLegendsUserMatch struct {
	ID            int `gorm:"primary_key"`
	ScillUserID   int //points to user id in scill database
	ChallengeID   int //points to challenge id in scill database
	GameStartTime int64
	GameLength    int
	GameID        int64 //match id in league of legends database
	ParticipantID int
	PlatformID    string
	GameMode      string
	GameType      string
	AccountID     string
	SummonerName  string
	SummonerID    string
	ChampionID 						int
	TeamID      					int
	Kills                           int
	Deaths                          int
	Assists                         int
	TotalDamageDealtToChampions     int
	GoldEarned                      int
	GoldSpent                       int
	TotalMinionsKilled              int
	NeutralMinionsKilled            int
	NeutralMinionsKilledTeamJungle  int
	NeutralMinionsKilledEnemyJungle int
	WardsPlaced                     int
	Victory 						bool
	Active							bool
}

type LeagueOfLegendsUserMatchPlayedTimeline struct {
	ID      						int `gorm:"primary_key"`
	MatchID	 						int
	FrameInterval					int
}
type LeagueOfLegendsUserMatchFrame struct {
	ID      						int `gorm:"primary_key"`
	TimeLineId						int  //Points to LeagueOfLegendsUserMatchPlayedTimeline
	Timestamp						int
	CurrentGold         			int `json:"currentGold"`
	TotalGold           			int `json:"totalGold"`
	Level               			int `json:"level"`
	Xp                  			int `json:"xp"`
	MinionsKilled       			int `json:"minionsKilled"`
	JungleMinionsKilled 			int `json:"jungleMinionsKilled"`

}
type LeagueOfLegendsUserMatchFrameEvent struct {
	ID      						int `gorm:"primary_key"`
	FrameId							int  //Points to LeagueOfLegendsUserMatchFrame
	Type							string
	Timestamp						int
	ItemId							int
	SkillSlot						int
	LevelUpType						string
	DidKill							bool  //if killer id is our part.id then here
	GotKilled						bool
	DidAssist						bool //if our part.id is in assistingParticipantIds then he made an assist
	PlacedWard						bool //if creatorId is our part.id
	KillerWard						bool //if killerId is our part.id
	WardType						string
	DestroyedBuilding				bool
	AssistedDestroyingBuilding		bool
	BuildingType 					string
	LaneType						string
	TowerType						string
	MonsterType						string
	MonsterSubType					string
}

type LeagueOfLegendsEvent struct {
	Type							string
	Timestamp						int
	ParticipantId					int
	CreatorId						int
	WardType 						string
	ItemId							int
	KillerId						int
	SkillSlot						int
	LevelUpType						string
	AssistingParticipantIds			[]struct{}
	BuildingType					string
	LaneType						string
	TowerType						string
	AfterId							int
	BeforeId						int
	VictimId						int
	monsterType						string
	monsterSubType					string
}

func main(){
	const addr = "postgresql://maxroach@localhost:26257/scill_database?sslmode=disable"
	db, err := gorm.Open("postgres", addr)
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	// Set to `true` and GORM will print out all DB queries.
	db.LogMode(false)

	db.AutoMigrate(
		&LeagueOfLegendsUserMatch{},
		&LeagueOfLegendsUserMatchPlayedTimeline{},
		&LeagueOfLegendsUserMatchFrame{},
		&LeagueOfLegendsUserMatchFrameEvent{},
		)

	//Get users with active LoL challenges
	//go gocron.Every(30).Seconds().Do(updateAllUsersLoLStats)

	//Get users with active lol challenges
	//Parse users one by one

			//getParticipantId() ->teamid and participantID
			//parseTeamStats()
			//parsePlayersStats()
			//parseTimeline()
			//Store to DB

			//Get Team stats: "teamId": 100,
			//Get Player stats:
			//Get Timeline -> get frames with $this->participantID
			//Store to DB

	//Setup dummy user data
	//Important: missing challange_id, scill_user_id and scill_user_challange_id
	var summonerName, summonerRegion = "NERVARlEN", "euw1"
	var apiToken = "RGAPI-adefc3ef-5357-4f11-85ed-d828b449572f" //Expires every 24h

	//Fetch users with active lol challenges
	//Collection of users
	//Loop thought them

	//Get Summoner Data
	summonerData := getSummonerData(summonerName, summonerRegion, apiToken)

	var userActiveMatch = LeagueOfLegendsUserMatch{}
	fmt.Println("start")
	//Check if the match is active

	if userHasActiveMatchWithChallenge(summonerName){
		var userMatch = LeagueOfLegendsUserMatch{}
		var userParticipantID int

		db.Where("summoner_name = ?", summonerName).First(&userMatch)

		summonerMatchData := getSummonerMatchData(summonerRegion, userMatch.GameID, apiToken)

		for _, s := range summonerMatchData.ParticipantIdentities {
			if s.Player.SummonerName == summonerName {
				userParticipantID = s.ParticipantID
			}
		}
		fmt.Println(userParticipantID)
		fmt.Println(summonerMatchData)
		fmt.Println(summonerMatchData.Participants)
		var userMatchStats = summonerMatchData.Participants[userParticipantID - 1].Stats

		userMatch.Active = false
		userMatch.Victory = userMatchStats.Win
		userMatch.ParticipantID = userParticipantID
		userMatch.GameLength = summonerMatchData.GameDuration
		userMatch.Kills = userMatchStats.Kills
		userMatch.Deaths = userMatchStats.Deaths
		userMatch.Assists = userMatchStats.Assists
		userMatch.TotalDamageDealtToChampions = userMatchStats.TotalDamageDealtToChampions
		userMatch.GoldEarned = userMatchStats.GoldEarned
		userMatch.GoldSpent = userMatchStats.GoldSpent
		userMatch.TotalMinionsKilled = userMatchStats.TotalMinionsKilled
		userMatch.NeutralMinionsKilled = userMatchStats.NeutralMinionsKilled
		userMatch.NeutralMinionsKilledTeamJungle = userMatchStats.NeutralMinionsKilledTeamJungle
		userMatch.NeutralMinionsKilledEnemyJungle = userMatchStats.NeutralMinionsKilledEnemyJungle
		userMatch.WardsPlaced = userMatchStats.WardsPlaced

		matchTimeline := getSummonerMatchTimeline(summonerRegion , userMatch.GameID, apiToken)
		fmt.Println("loop1111xxx")
		timeline := LeagueOfLegendsUserMatchPlayedTimeline{FrameInterval: matchTimeline.FrameInterval, MatchID:userMatch.ID}
		db.Create(&timeline)

		for _, s := range matchTimeline.Frames {
			newFrame := LeagueOfLegendsUserMatchFrame{TimeLineId:timeline.ID, Timestamp:s.Timestamp}
			db.Create(&newFrame)
			println(newFrame.ID)

			for _, l := range s.ParticipantFrames {
				if l.ParticipantID == userParticipantID {
					//Setup fn for insert into db
					newFrame.CurrentGold = l.CurrentGold
					newFrame.JungleMinionsKilled = l.JungleMinionsKilled
					newFrame.Level = l.Level
					newFrame.TotalGold = l.TotalGold
					newFrame.MinionsKilled = l.MinionsKilled
					db.Save(&newFrame)
				}
			}

			for _, m := range s.Events {
				//Insert events fn
				newEvent := LeagueOfLegendsUserMatchFrameEvent{Timestamp:m.Timestamp,FrameId:newFrame.ID}
				db.Create(&newEvent)
				newEvent.Type = m.Type
				newEvent.ItemId = m.ItemId
				newEvent.BuildingType = m.BuildingType
				newEvent.WardType = m.WardType
				newEvent.TowerType = m.TowerType
				db.Save(&newEvent)

			}

		}
		//timeline := LeagueOfLegendsUserMatchPlayedTimeline{FrameInterval: matchTimeline.FrameInterval, MatchID:userMatch.ID}
		//db.Create(LeagueOfLegendsUserMatchPlayedTimeline{FrameInterval: matchTimeline.FrameInterval, MatchID:userMatch.ID})
		//fmt.Println(timeline)



	} else if userHasActiveMatch(summonerRegion, summonerData.ID, apiToken) {
		fmt.Println("loop1")
		//Fetch active match data
		summonerActiveMatch := getSummonerActiveMatch(summonerRegion, summonerData.ID, apiToken)
		var championID int
		var teamID  int

		//Extract users championID and teamID form active match data
		for _, s := range summonerActiveMatch.Participants {
			if s.SummonerID == summonerData.ID {
				championID = s.ChampionID
				teamID = s.TeamID
			}
		}

		checkQuery := "SELECT game_id, summoner_name FROM league_of_legends_user_matches WHERE game_id=? AND summoner_name=?"

		//Check if there is a entry for this match/user/challenge in the db if not create one
		if checkErr := db.Raw(checkQuery, summonerActiveMatch.GameID, summonerData.Name).Scan(&userActiveMatch).Error; checkErr != nil {
			db.Create(&LeagueOfLegendsUserMatch{ChampionID: championID, TeamID:teamID, GameStartTime: summonerActiveMatch.GameStartTime, GameID:summonerActiveMatch.GameID ,PlatformID:summonerActiveMatch.PlatformID ,GameMode:summonerActiveMatch.GameMode,GameType:summonerActiveMatch.GameType,AccountID:summonerData.AccountID,SummonerName:summonerData.Name,SummonerID:summonerData.ID, Active:true})
		}
	}else {
		var userMatch = LeagueOfLegendsUserMatch{}
		var userParticipantID int
		fmt.Println("loop2")
		db.Where("summoner_name = ?", summonerName).First(&userMatch)

		summonerMatchData := getSummonerMatchData(summonerRegion, userMatch.GameID, apiToken)

		for _, s := range summonerMatchData.ParticipantIdentities {
			if s.Player.SummonerName == summonerName {
				userParticipantID = s.ParticipantID
			}
		}

		var userMatchStats = summonerMatchData.Participants[userParticipantID - 1].Stats

		userMatch.Active = false
		userMatch.Victory = userMatchStats.Win
		userMatch.ParticipantID = userParticipantID
		userMatch.GameLength = summonerMatchData.GameDuration
		userMatch.Kills = userMatchStats.Kills
		userMatch.Deaths = userMatchStats.Deaths
		userMatch.Assists = userMatchStats.Assists
		userMatch.TotalDamageDealtToChampions = userMatchStats.TotalDamageDealtToChampions
		userMatch.GoldEarned = userMatchStats.GoldEarned
		userMatch.GoldSpent = userMatchStats.GoldSpent
		userMatch.TotalMinionsKilled = userMatchStats.TotalMinionsKilled
		userMatch.NeutralMinionsKilled = userMatchStats.NeutralMinionsKilled
		userMatch.NeutralMinionsKilledTeamJungle = userMatchStats.NeutralMinionsKilledTeamJungle
		userMatch.NeutralMinionsKilledEnemyJungle = userMatchStats.NeutralMinionsKilledEnemyJungle
		userMatch.WardsPlaced = userMatchStats.WardsPlaced

		matchTimeline := getSummonerMatchTimeline(summonerRegion , userMatch.GameID, apiToken)
		fmt.Println("loop1111xxx")
		timeline := LeagueOfLegendsUserMatchPlayedTimeline{FrameInterval: matchTimeline.FrameInterval, MatchID:userMatch.ID}
		db.Create(&timeline)

		for _, s := range matchTimeline.Frames {
			newFrame := LeagueOfLegendsUserMatchFrame{TimeLineId: timeline.ID, Timestamp: s.Timestamp}
			db.Create(&newFrame)
			println(newFrame.ID)

			for _, l := range s.ParticipantFrames {
				if l.ParticipantID == userParticipantID {
					//Setup fn for insert into db
					newFrame.CurrentGold = l.CurrentGold
					newFrame.JungleMinionsKilled = l.JungleMinionsKilled
					newFrame.Level = l.Level
					newFrame.TotalGold = l.TotalGold
					newFrame.MinionsKilled = l.MinionsKilled
					db.Save(&newFrame)
				}
			}

			for _, m := range s.Events {
				//Insert events fn
				newEvent := LeagueOfLegendsUserMatchFrameEvent{Timestamp: m.Timestamp, FrameId: newFrame.ID}
				db.Create(&newEvent)
				newEvent.Type = m.Type
				newEvent.ItemId = m.ItemId
				newEvent.BuildingType = m.BuildingType
				newEvent.WardType = m.WardType
				newEvent.TowerType = m.TowerType
				db.Save(&newEvent)
			}
		}

	}


	//Get Summoner Active Games
	/*
	summonerActiveMatch := getSummonerActiveMatch(summonerRegion, summonerData.ID, apiToken)
	fmt.Println(summonerActiveMatch)
	fmt.Println("GameID")
	fmt.Println(summonerActiveMatch.GameID)
*/
	//Get Summoner Full Match Data
	/*
	summonerMatchData := getSummonerMatchData(summonerRegion, summonerActiveMatch.GameID, apiToken)
	fmt.Println(summonerMatchData)
	fmt.Println("Participants List")
	fmt.Println(summonerMatchData.ParticipantIdentities)
	fmt.Println(summonerMatchData.Teams)
	fmt.Println("Done...")
*/
	/*testing fn
	data := testMatchData()
	fmt.Println(data.ParticipantIdentities[0].Player.SummonerName)
	fmt.Println(data.Teams[0].Win)
	fmt.Println(data.GameMode)
	//fn GetSummonerData
	 */
}

func filterParticipantData(participantId int, participants ...struct{}) {
	for _, participant := range participants {
		fmt.Println(participant)
	}
}

func getSummonerData(summonerName string, summonerRegion string, apiToken string)  SummonerData{
	summonerData := SummonerData{}
	var getSummonerDataUrl = "https://region.api.riotgames.com/lol/summoner/v4/summoners/by-name/summonerName"

	getSummonerDataUrl = strings.Replace(getSummonerDataUrl, "region", summonerRegion, 1)
	getSummonerDataUrl = strings.Replace(getSummonerDataUrl, "summonerName", summonerName, 1)

	request, _ := http.NewRequest("GET", getSummonerDataUrl, nil)
	request.Header.Set("X-Riot-Token", apiToken)

	client := &http.Client{}
	response, err := client.Do(request)

	if err != nil {
		fmt.Printf("The HTTP request failed with error %s\n", err)
	} else {
		data, _ := ioutil.ReadAll(response.Body)
		json.Unmarshal([]byte(data), &summonerData)
	}

	return summonerData
}

func userHasActiveMatchWithChallenge(summonerName string) bool{
	const addr = "postgresql://maxroach@localhost:26257/s_database?sslmode=disable"
	db, err := gorm.Open("postgres", addr)
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()
	userMatch := LeagueOfLegendsUserMatch{}

	if dbc := db.Where("summoner_name = ?", summonerName).First(&userMatch); dbc.Error != nil {

		return false
	}else {
		if userMatch.Active == true {
			return true
		}else {
			return false
		}
	}

}

func userHasActiveMatch(summonerRegion string, summonerID string, apiToken string) bool{
	var getActiveMatchUrl = "https://region.api.riotgames.com/lol/spectator/v4/active-games/by-summoner/summonerID"

	getActiveMatchUrl = strings.Replace(getActiveMatchUrl, "region", summonerRegion, 1)
	getActiveMatchUrl = strings.Replace(getActiveMatchUrl, "summonerID", summonerID, 1)

	request, _ := http.NewRequest("GET", getActiveMatchUrl, nil)
	request.Header.Set("X-Riot-Token", apiToken)

	client := &http.Client{}
	response, err := client.Do(request)

	//TODO Rewrite error handling
	if err != nil {
		//Write error to log
		fmt.Printf("The HTTP request failed with error %s\n", err)
	}

	//TODO Rewrite this
	if response.StatusCode == 404 {
		return false
	}else if response.StatusCode >= 200 && response.StatusCode <= 299 {
		return true
	}else {
		return false
	}
}

func getSummonerActiveMatch(summonerRegion string, summonerID string, apiToken string)  SummonerActiveMatch{
	summonerActiveMatch := SummonerActiveMatch{}
	var getActiveMatchUrl = "https://region.api.riotgames.com/lol/spectator/v4/active-games/by-summoner/summonerID"

	getActiveMatchUrl = strings.Replace(getActiveMatchUrl, "region", summonerRegion, 1)
	getActiveMatchUrl = strings.Replace(getActiveMatchUrl, "summonerID", summonerID, 1)

	request, _ := http.NewRequest("GET", getActiveMatchUrl, nil)
	request.Header.Set("X-Riot-Token", apiToken)

	client := &http.Client{}
	response, err := client.Do(request)

	if err != nil {
		// TODO Write to log for all err
		fmt.Printf("The HTTP request failed with error %s\n", err)
	} else {
		data, _ := ioutil.ReadAll(response.Body)
		json.Unmarshal([]byte(data), &summonerActiveMatch)
	}

	return summonerActiveMatch
}

func getSummonerMatchData(summonerRegion string, lolMatchId int64, apiToken string)  LeagueOfLegendsMatch{
	str := strconv.FormatInt(lolMatchId, 10)

	summonerMatchData := LeagueOfLegendsMatch{}
	var getFullMatchUrl = "https://region.api.riotgames.com/lol/match/v4/matches/matchID"

	getFullMatchUrl = strings.Replace(getFullMatchUrl, "region", summonerRegion, 1)
	getFullMatchUrl = strings.Replace(getFullMatchUrl, "matchID", str, 1)

	request, _ := http.NewRequest("GET", getFullMatchUrl, nil)
	request.Header.Set("X-Riot-Token", apiToken)

	client := &http.Client{}
	response, err := client.Do(request)

	if err != nil {
		fmt.Printf("The HTTP request failed with error %s\n", err)
	} else {
		data, _ := ioutil.ReadAll(response.Body)
		json.Unmarshal([]byte(data), &summonerMatchData)
	}

	return summonerMatchData
}

func getSummonerMatchTimeline(summonerRegion string, lolMatchId int64, apiToken string) MatchTimeline{
	str := strconv.FormatInt(lolMatchId, 10)

	summonerMatchTimeline := MatchTimeline{}
	getTimelineUrl := "https://region.api.riotgames.com/lol/match/v4/timelines/by-match/matchID"

	getTimelineUrl = strings.Replace(getTimelineUrl, "region", summonerRegion, 1)
	getTimelineUrl = strings.Replace(getTimelineUrl, "matchID", str, 1)

	request, _ := http.NewRequest("GET", getTimelineUrl, nil)
	request.Header.Set("X-Riot-Token", apiToken)

	client := &http.Client{}
	response, err := client.Do(request)

	if err != nil {
		fmt.Printf("The HTTP request failed with error %s\n", err)
	} else {
		data, _ := ioutil.ReadAll(response.Body)
		json.Unmarshal([]byte(data), &summonerMatchTimeline)
	}

	return summonerMatchTimeline
}

//TODO Add ScillUSerID
func activeMatchExists(gameid int64, summonerName string)  bool{
	const addr = "postgresql://maxroach@localhost:26257/s_database?sslmode=disable"
	db, err := gorm.Open("postgres", addr)
	if err != nil {
		log.Fatal(err)
	}
	defer db.Close()

	// Set to `true` and GORM will print out all DB queries.
	db.LogMode(false)

	db.Exec("SELECT ")
	return true
}