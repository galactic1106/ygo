export function getCardBackground(frameType: string, vertical?: boolean): string {
    switch (frameType) {
        case 'normal':
            return 'bg-[#F8D37A]'; // Normal Monster
        case 'effect':
            return 'bg-[#D19B6A]'; // Effect Monster
        case 'ritual':
            return 'bg-[#6DC3E6]'; // Ritual Monster
        case 'fusion':
            return 'bg-[#A97EDB]'; // Fusion Monster
        case 'synchro':
            return 'bg-[#EDEDED]'; // Synchro Monster
        case 'xyz':
            return 'bg-[#222222]'; // Xyz Monster
        case 'link':
            return 'bg-[#3A6DB1]'; // Link Monster
        case 'spell':
            return 'bg-[#1E9C4B]'; // Spell Card
        case 'trap':
            return 'bg-[#B85A8A]'; // Trap Card
        case 'token':
            return 'bg-[#EDEDED]'; // Token (use Synchro color)
        case 'skill':
            return 'bg-[#6DC3E6]'; // Skill Card (use Ritual color)
        case 'normal_pendulum':
            if (vertical) {
                return 'bg-[linear-gradient(to_bottom,#F8D37A_0%,#1E9C4B_100%)]';
            }
            return 'bg-[linear-gradient(to_right,#F8D37A_0%,#1E9C4B_100%)]';
        case 'effect_pendulum':
            if (vertical) {
                return 'bg-[linear-gradient(to_bottom,#D19B6A_0%,#1E9C4B_100%)]';
            }
            return 'bg-[linear-gradient(to_right,#D19B6A_0%,#1E9C4B_100%)]';
        case 'fusion_pendulum':
            if (vertical) {
                return 'bg-[linear-gradient(to_bottom,#A97EDB_0%,#1E9C4B_100%)]';
            }
            return 'bg-[linear-gradient(to_right,#A97EDB_0%,#1E9C4B_100%)]';
        case 'synchro_pendulum':
            if (vertical) {
                return 'bg-[linear-gradient(to_bottom,#EDEDED_0%,#1E9C4B_100%)]';
            }
            return 'bg-[linear-gradient(to_right,#EDEDED_0%,#1E9C4B_100%)]';
        case 'xyz_pendulum':
            if (vertical) {
                return 'bg-[linear-gradient(to_bottom,#222222_0%,#1E9C4B_100%)]';
            }
            return 'bg-[linear-gradient(to_right,#222222_0%,#1E9C4B_100%)]';
        case 'ritual_pendulum':
            if (vertical) {
                return 'bg-[linear-gradient(to_bottom,#6DC3E6_0%,#1E9C4B_100%)]';
            }
            return 'bg-[linear-gradient(to_right,#6DC3E6_0%,#1E9C4B_100%)]';
        default:
            return '';
    }
}
